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
		<h1><i class="fa fa-dashboard"></i> Solicitudes - Anular Beneficios en Masa </h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">

			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="tile">

					<form class="row" name="form1" method="get" action="{{route ('anular.create')}}" accept-charset="UTF-8">
										<div class="form-group col-md-4">
					<label class="control-label">Beneficio</label>
					<select id="beneficio_id"  name="beneficio_id" class="form-control" required="">	
						<option value="">Seleccione Beneficio</option>
						@foreach ($beneficios as $categ)
						<option value="{{ $categ->codigo }}">{{ $categ->descripcion }}</option>	
						@endforeach	
					</select>
				</div>
						
						<div class="form-group col-md-2">
							<label class="control-label">Tipo de Nomina</label>
							<select class='form-control' name='tipon' id='tipon'>
								@if($perfil==1)
								<option value="ALTO NIVEL">ALTO NIVEL</option>
								<option value="CONTRATADOS">CONTRATADOS</option>
								<option value="EMPLEADOS">EMPLEADOS</option>
								<option value="OBREROS">OBREROS</option>
								@endif
								@if($perfil==2)
								<option value="{{ $nomina }}">{{ $nomina }}</option>
								@endif
							</select>

						</div>
						<div class="form-group col-md-2">
					<label class="control-label">Fecha Registro</label>
					<input class="form-control datepicker" type="text" name="fecha_registro" id="fecha_registro" placeholder="Fecha Registro" maxlength="12">
				</div>

						<div class="form-group col-md-2">
					<label class="control-label">Fecha Trámite</label>
					<input class="form-control datepicker" type="text" name="fecha_tramite" id="fecha_tramite" placeholder="Fecha Registro" maxlength="12">
				</div>
						<div class="tile-footer">
							<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Buscar</button>
						</div>
					</form>  
				</div>
				
			</div>	
			
		</div>	
		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-body">
						<table class="table table-hover table-bordered" id="sampleTable">
							<thead>
								<tr>
									<th colspan="7">Tipo de Nomina: {{ $nomina }}</th>
								</tr>
								<tr>
									<th>#</th>
									<th>Cedula</th>
									<th colspan="2">Trabajador</th>
									<th>Fecha Ingreso</th>
									<th>Categoria</th>

								</tr>
							</thead>
							<?php $i=1; ?>
						</table>
						<div id="sampleTable_paginate" class="dataTables_paginate paging_simple_numbers">
										</div>
					</div>
				</div>
			</div>

		</div>
@push ('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js"
integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<script type="text/javascript" language="javascript">

	$ = jQuery;
	jQuery(document).ready(function () {
		$("input#fecha_tramite").bind('change', function (event) {
			   
				document.form1.fecha_registro.value = "";	
				alert("paso");
        });
});

	</script>


@endpush 
@stop