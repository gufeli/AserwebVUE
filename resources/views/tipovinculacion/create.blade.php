@extends('layouts.default')

@section('content')
  <div class="container">
            <h2>Crear un nuevo Tipo de vinculacion </h2>
            <hr>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post" action="{{ route('tipovinculacion.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Tipo de vinculacion* </label>
                    <input type="text" name="name" class="form-control">
                </div>
                <a href="{{ route('tipovinculacion.index') }}" class="btn btn-default">Cancelar</a>
                <button type="submit" class="btn btn-primary">Crear</button>
            </form>
        </div>
@endsection