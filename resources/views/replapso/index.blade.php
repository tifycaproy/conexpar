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
		<h1><i class="fa fa-dashboard"></i> Solicitudes - Generar Listado por Lapso </h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">

			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="tile">

					<form class="row" name="form1" method="get" action="{{route ('rptlapso.create')}}" accept-charset="UTF-8">
						<div class="form-group col-md-3">
							<label class="control-label">Beneficios</label>
							<select class='form-control' name='beneficio_id' id='beneficio_id'>
								<option value="">Seleccione Beneficio</option>
							@foreach($beneficios as $bene)
							   <option value="{{ $bene->codigo}}">{{$bene->descripcion}}</option>
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
						<label class="control-label">Desde</label>
						<input class="form-control datepicker" type="text" name="desde" id="desde" placeholder="Desde" maxlength="12" required="">
				       </div>
					   <div class="form-group col-md-2">
						<label class="control-label">Hasta</label>
						<input class="form-control datepicker" type="text" name="hasta" id="hasta" placeholder="Hasta" maxlength="12" required="">
				       </div>
                       <div class="form-group col-md-2">
							<label class="control-label">Tipo</label>
							<select class='form-control' name='tipol' id='tipol' required="">
								<option value="1">Resumen</option>
								<option value="2">Detalle</option>
								
							</select>

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
		@endsection