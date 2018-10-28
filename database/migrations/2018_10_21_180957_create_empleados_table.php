<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->integer('id');
            $table->string('name',50);
            $table->string('apellido',50);
            $table->integer('telefono');
            $table->string('correoelectronico',50);
            $table->integer('tipoid')->unsigned();
            $table->foreign('tipoid')->references('id')->on('tipovinculaciones');
            $table->date('fechadenacimiento');
            $table->double('salario');
            $table->integer('id_cargo')->unsigned();
            $table->foreign('id_cargo')->references('id')->on('cargos'); 
            $table->integer('id_sede')->unsigned();
            $table->foreign('id_sede')->references('id')->on('sedes');    
            $table->timestamps();
            $table->unique('id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}
