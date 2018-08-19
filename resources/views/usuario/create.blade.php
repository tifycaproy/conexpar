@extends('layouts.header')

@section('content')

<div class="row">
     <div class="col-lg-6">
        <h1 class="page-header">Usuarios</h1>
    </div>
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="{{ route("usuarios.index") }}"><i class="fa fa-fw fa-user"></i> Usuarios</a></li>
            <li>Crear</li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <p class="text-right"><a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-primary"><i class="fa fa-fw fa-list"></i> Ver lista</a></p>
    </div>
</div>

<form role="form" action="{{ route('usuarios.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                <label>Nombre</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}" maxlength="120" required autofocus>
                @if ($errors->has('nombre'))
                    <p class="help-block">{{ $errors->first('name') }}</p>
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label>Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" maxlength="100" required>
                @if ($errors->has('email'))
                    <p class="help-block">{{ $errors->first('email') }}</p>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label>Clave</label>
                <input type="password" class="form-control" name="password" maxlength="100" required>
                @if ($errors->has('password'))
                    <p class="help-block">{{ $errors->first('password') }}</p>
                @endif
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Confirmar Clave</label>
                <input type="password" class="form-control" name="password_confirmation" maxlength="100" required>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <label>Seleccione Rol de Usuario</label>
                <select name="rol_id" id="rol_id" class="form-control">
                    <option>Seleccione Rol</option>
                 @foreach($roles as $roles)
                 <option value="{{ $roles->id }}">{{ $roles->descripcion }}</option>
                 @endforeach    
                </select>
            </div>
        </div>
        <div class="form-group col-md-7">
            <input class="form-check-input" type="checkbox" value="1" name="altonivel" id="altonivel">
            <label class="form-check-label" for="altonivel">Alto Nivel</label>
                    
            <input class="form-check-input" type="checkbox" value="1" name="contratados" id="contratados">
            <label class="form-check-label" for="contratados">Contratados</label>

            <input class="form-check-input" type="checkbox" value="1" name="empleados" id="empleados">
            <label class="form-check-label" for="empleados">Empleados</label>

            <input class="form-check-input" type="checkbox" value="1" name="obreros" id="obreros">
            <label class="form-check-label" for="obreros">Obreros</label>

            <input class="form-check-input" type="checkbox" value="1" name="jubilados" id="jubilados">
            <label class="form-check-label" for="jubilados">Jubilados</label>

        </div>

    </div>
    <div class="row"><div class="col-lg-6"><button type="submit" class="btn btn-success"><i class="fa fa-fw fa-check"></i> Guardar</button>  <a href="{{ route('usuarios.index') }}" class="btn btn-primary"><i class="fa fa-fw fa-list"></i> Volver a la lista</a></div>
</form>


@endsection
