@extends ('layouts.header')
@section('content')
<div class="row">
    <div class="col-lg-10">
        @if($notificacion=Session::get('notificacion'))
        <div class="alert alert-success">{{ $notificacion }}</div>
        @endif
        @if($notificacion_error=Session::get('notificacion_error'))
        <div class="alert alert-danger">{{ $notificacion_error }}</div>
        @endif
    </div>
</div>


<div class="app-title">
    <div>
        <h1><i class="fa fa-dashboard"></i> Editar firmas</h1>

    </div>
    <ul class="app-breadcrumb breadcrumb side">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item active"><a href="{{ route('firmas.index') }}">Atrás</a></li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <form class="row" role="form" action="{{ route('firmas.update', ($firmas->id)) }}" method="POST">
               {{ csrf_field() }}
               {{ method_field('PUT') }}

                <div class="form-group col-md-6">
                    <label class="control-label">Nombre</label>
                    <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{ $firmas->nombre }}" required="">
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">Nivel Educativo</label>
                    <input class="form-control" value="{{ $firmas->nivel }}"type="text" name="nivel" id="nivel" placeholder="Nivel Educativo" required="">
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">Cargo</label>
                    <input class="form-control" type="text" name="cargo" id="cargo" placeholder="Cargo" required="" value="{{ $firmas->cargo }}">
                </div>
                <div class="form-group col-md-2">
                    <label class="control-label">Posición</label>
                    <input class="form-control" type="text" name="posicion" id="posicion" placeholder="Posición" required="" value="{{ $firmas->posicion }}">
                </div>

            <div class="form-group">
                <label class="control-label">Estatus</label>
                <div class="col-sm-8">
                    <select id="estatus" class="form-control">  
                        <option value="">Seleccione Estatus</option>
                        <option value="Activo"@if(old('estatus', $firmas->estatus)=='Activo') selected @endif>Activo</option>
                        <option value="Desactivado"@if(old('estatus', $firmas->estatus)=='Desactivado') selected @endif>Desactivado</option>
                    </select>
                </div>
            </div>
                    <div class="tile-footer">
                     <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Guardar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('firmas.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>

                </div>

        </form>
    </div>
</div>
</div>



@endsection