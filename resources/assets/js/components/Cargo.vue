<template>
    <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Cargos
                        <button type="button" @click="abrirModal('cargo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" id="opcion" name="opcion">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cargo in arrayCargo" :key="cargo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('cargo','actualizar',cargo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>&nbsp;
                                        <template v-if="cargo.condicion">                                      
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCargo(cargo.id)">
                                                <i class="icon-trash"></i>
                                            </button>                    
                                        </template>
                                        <template v-else>                                      
                                            <button type="button" class="btn btn-info btn-sm" @click="activarCargo(cargo.id)">
                                                <i class="icon-check"></i>
                                            </button>                    
                                        </template>
                                    </td>
                                    <td v-text="cargo.nombre"></td>
                                    <td ></td>
                                    <td>
                                        <div v-if="cargo.condicion">  
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>  
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1 ">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de categoría">
                                    </div>
                                </div>
                                    <div v-show="errorCargo" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjCargo" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                <!-- <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="inecesario">
                                    </div>
                                </div> -->
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary"  @click="registrarCargo()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary"  @click="actualizarCargo()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- Fin del modal-->
            <!-- Inicio del modal Eliminar -->
            <!-- <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-danger" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Eliminar Categoría</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Estas seguro de eliminar la categoría?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-danger">Eliminar</button>
                        </div>
                    </div>
                    < /.modal-content>
                </div>
                < /.mmodal-dialog >
            </div> -->
            <!-- Fin del modal Eliminar -->
        </main>
</template>

<script>
    export default {
        data (){
            return{      
                cargo_id: 0,
                nombre : '',
                arrayCargo : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCargo : 0,
                errorMostrarMsjCargo : [],
                pagination : {
                'total'       :0,                                                     
                'current_page':0,
                'per_page'    :0,                          
                'last_page'   :0,               
                'from'        :0,      
                'to'          :0,
                },
                offset : 3
            }
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Cacula los elemntos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to){
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;

                }
                var to = this.pagination.from + this.offset;
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray =[]
                while(from <= to ){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }


        },

        methods : {
            listarCargo(page){
                let me=this;
                var url='/cargo?page=' + page;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayCargo = respuesta.cargos.data;
                    me.pagination = respuesta.pagination;
            })
            .catch(function (error) {
                console.log(error);
            }); 
            },
            cambiarPagina(page){
                let me = this;
                //Actualizar pagina actual
                this.pagination.current_page = page;
                //Envia la peticion para visualizar la data de esa página
                me.listarCargo(page);

            },
            registrarCargo(){
                if(this.validarCargo()){
                   return; 
                }
                let me = this;
                axios.post('/cargo/registrar',{
                    'nombre': this.nombre,
                }).then(function (response) {
                me.cerrarModal();
                me.listarCargo();
            })
            .catch(function (error) {
                console.log(error);
            });
            },
            actualizarCargo(){
                if(this.validarCargo()){
                   return; 
                }
                let me = this;
                axios.put('/cargo/actualizar',{
                    'nombre': this.nombre,
                    'id' : this.cargo_id
                }).then(function (response) {
                me.cerrarModal();
                me.listarCargo();
            })
            .catch(function (error) {
                console.log(error);
            });
             },
            desactivarCargo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de eliminar cargo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/cargo/desactivar',{
                    'id' : id
                    }).then(function (response) {
                    me.listarCargo();
                    swalWithBootstrapButtons(
                    'Desactivado!',
                    'El cargo ha sido desactivado con exito.',
                    'success'
                    )
                    })                  
                    .catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })

            },
            activarCargo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                })

                swalWithBootstrapButtons({
                title: 'Esta seguro de activar cargo?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/cargo/activar',{
                    'id' : id
                    }).then(function (response) {
                    me.listarCargo();
                    swalWithBootstrapButtons(
                    'Activado!',
                    'El registro ha sido activado con exito.',
                    'success'
                    )
                    })                  
                    .catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                }
                })

            },
            validarCargo(){
                this.errorCargo = 0;
                this.errorMostrarMsjCargo =[];

                if(!this.nombre) this.errorMostrarMsjCargo.push("El nombre del cargo no debe estar vacio");
                if(this.errorMostrarMsjCargo.length) this.errorCargo = 1;

                return this.errorCargo;
            },
            cerrarModal(){
                this.modal = 0;
                this.tituloModal = '';
                this.nombre='';
            },
            abrirModal(modelo, accion, data=[]){
                switch(modelo){
                    case "cargo":
                    {
                        switch(accion){
                            case 'registrar': 
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Cargo';
                                this.nombre = '';
                                this.tipoAccion = 1;
                                break;

                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal = 1;
                                this.tituloModal = 'Actualizar Cargo';
                                this.tipoAccion = 2;
                                this.cargo_id = data['id'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }

                    }
                }
            },
        },
        mounted() {
            this.listarCargo();
        }
    }
</script>
<style>
 .modal-content{
     width: 100% !important;
     position: absolute !important;
 }
 .mostrar{
     display:  list-item !important;
     opacity: 1 !important;
     position: absolute !important;
     background-color: #3c29297a !important;
 }
 .div-error{
     display: flex;
     justify-content: center;
 }
 .text-error{
     color: red !important;
     font-weight: bold;
 }
</style>
