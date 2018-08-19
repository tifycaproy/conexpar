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
		<h1><i class="fa fa-dashboard"></i> Crear Firmas</h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item active"><a href="{{ route('firmas.index') }}">Atrás</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="tile">
			
 <form name="form1" class="row"  enctype="multipart/form-data" method="POST" action="{{route ('firmas.store')}}" accept-charset="UTF-8"><input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

				
				<div class="form-group col-md-6">
					<label class="control-label">Nombre</label>
					<input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre" required="">
				</div>
				<div class="form-group col-md-6">
					<label class="control-label">Nivel Educativo</label>
					<input class="form-control" type="text" name="nivel" id="nivel" placeholder="Nivel Educativo" required="">
				</div>
				<div class="form-group col-md-6">
					<label class="control-label">Cargo</label>
					<input class="form-control" type="text" name="cargo" id="cargo" placeholder="Cargo" required="">
				</div>
				<div class="form-group col-md-2">
					<label class="control-label">Posición</label>
					<input class="form-control" type="text" name="posicion" id="posicion" placeholder="Posición" required="">
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Estatus</label>
					<select id="estatus"  name="estatus" class="form-control">	
						<option value="">Seleccione</option>
						<option value="Activo">Activo</option>
						<option value="Desactivado">Desactivado</option>
					</select>
				</div>


				<div class="tile-footer">
						<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Guardar</button>&nbsp;&nbsp;&nbsp;<a class="btn btn-secondary" href="{{ route('beneficios.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</a>
			</div>
		</form>

	</div>
</div>
</div>
</div>

@push ('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script type="text/javascript" language="javascript">
	$ = jQuery;
	jQuery(document).ready(function () {
	$("input#codigo").bind('keydown', function (event) {

			if(event.shiftKey)
			{
				event.preventDefault();
			}
			if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 241 )    {
			}
			else {
				if (event.keyCode < 95) {
					if (event.keyCode < 48 || event.keyCode > 57) {
						event.preventDefault();
					}
				} 
				else {
					if (event.keyCode < 96 || event.keyCode > 105) {
						event.preventDefault();
					}
				}
			}        
			;
		});

	$("input#descripcion").bind('change', function (event) {
		  var valor =  $(this).val();
          valor = valor.toUpperCase();  
           $('#descripcion').val(valor);
	});

});

</script>

@endpush 
@stop