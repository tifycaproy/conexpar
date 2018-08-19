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
		<h1><i class="fa fa-dashboard"></i> Solicitudes - Generar Listado Diario </h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">

			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="tile">

					<form class="row" name="form1" method="get" action="{{route ('rptsolicitud.create')}}" accept-charset="UTF-8">
										<div class="form-group col-md-4">
					<label class="control-label">Beneficio</label>
					<select id="beneficio_id"  name="beneficio_id" class="form-control">	
						<option value="">Seleccione Beneficio</option>
						@foreach ($beneficio as $categ)
						<option value="{{ $categ->codigo }}">{{ $categ->descripcion }}</option>	
						@endforeach	
					</select>
				</div>
						
						<div class="form-group col-md-2">
							<label class="control-label">Tipo de Nomina</label>
							<select class='form-control' name='tipon' id='tipon' required="">
								@if($perfil==1)
								<option value="ALTO NIVEL">ALTO NIVEL</option>
								<option value="CONTRATADOS">CONTRATADOS</option>
								<option value="EMPLEADOS">EMPLEADOS</option>
								<option value="OBREROS">OBREROS</option>
								<option value="JUBILADOS">JUBILADOS</option>
								@endif
								@if($perfil==2)
								<option value="{{ $nomina }}">{{ $nomina }}</option>
								@endif
							</select>

						</div>
						<div class="form-group col-md-2">
							<label class="control-label">Tipo Fecha</label>
						<select name="tipo_fecha" id="tipo_fecha" class="form-control">
							<option value="1">Fecha Registro</option>
							<option value="2">Fecha Trámite</option>
						</select>	
				       </div>
						<div class="form-group col-md-2">
						<label class="control-label">Fecha</label>
						<input class="form-control datepicker" type="text" name="fecha_registro" id="fecha_registro" placeholder="Fecha Registro" maxlength="12" >
				       </div>
                       <div class="form-group col-md-2">
							<label class="control-label">Generar</label>
							<select class='form-control' name='tipor' id='tipor' required="">
								<option value="1">Vista Previa</option>
								<option value="2">Pdf</option>
								<option value="3">Excel</option>
							</select>

				       </div>

						<div class="tile-footer">
							<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Generar</button>
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
		@endsection