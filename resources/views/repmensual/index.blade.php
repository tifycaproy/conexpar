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
		<h1><i class="fa fa-dashboard"></i> Solicitudes - Generar Listado Mensual </h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">

			</ul>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="tile">

					<form class="row" name="form1" method="get" action="{{route ('rptmensual.create')}}" accept-charset="UTF-8">
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
						<label class="control-label">Mes</label>
						<select name="mes" id="mes" class="form-control">
							<option value="">Seleccione Mes</option>
							<option value="11">Enero</option>
							<option value="02">Febrero</option>
							<option value="03">Marzo</option>
							<option value="04">Abril</option>
							<option value="05">Mayo</option>
							<option value="06">Junio</option>
							<option value="07">Julio</option>
							<option value="08">Agosto</option>
							<option value="09">Septiembre</option>
							<option value="10">Octubre</option>
							<option value="11">Noviembre</option>
							<option value="12">Diciembre</option>
						</select>	
				       </div>
						<div class="form-group col-md-2">
						<label class="control-label">Fecha Trámite</label>
						<input class="form-control datepicker" type="text" name="fecha_tramite" id="fecha_tramite" placeholder="Fecha Trámite" maxlength="12" >
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