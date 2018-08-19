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
		<h1><i class="fa fa-dashboard"></i> Generar Reportes de Solicitud de Beneficio</h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		
		<li class="breadcrumb-item active"><a href="{{ route('rptsolicitud.index') }}">Atrás</a></li>
	</ul>
</div>
	<div class="row">
		<div class="col-md-12">
			<div class="tile">
			   <form class="row" name="form1" method="get" action="" accept-charset="UTF-8">
				<div class="form-group col-md-4">
					<label class="control-label">Beneficio</label>
					<input type="hidden" name="beneficio_id" id="beneficio_id" value="{{$beneficio_id}}">
					<input type="text" name="beneficio" id="beneficio" value="{{$beneficio_id}}" class="form-control" readonly="">
				</div>
				<div class="form-group col-md-2">
							<label class="control-label">Tipo de Nomina</label>
							<input type="text" name="tipon" id="tipon" class="form-control" value="{{$nomina}}" readonly="">
				</div>
				<div class="form-group col-md-2">
					<label class="control-label">Fecha Registro</label>
					<input class="form-control datepicker" type="text" name="fecha_registro" id="fecha_registro" placeholder="Fecha Registro" maxlength="12" value="{{$fecha_registro}}" readonly="">
				</div>
				<div class="form-group col-md-2">
					<label class="control-label">Fecha Trámite</label>
					<input class="form-control datepicker" type="text" name="fecha_tramite" id="fecha_tramite" placeholder="Fecha Registro" maxlength="12" value="{{$fecha_tramite}}" readonly="">
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
									<th>#</th>
									<th>Cedula</th>
									<th colspan="2">Trabajador</th>
									<th>Categoria</th>
                                    <th align="right">Monto</th>
                                    <th align="right">Retroactivo</th>
								</tr>
								@foreach($solicitud as $sol)
								<tr>
									<td>{{ $sol->nrosolicitud}}</td>
									<td>{{ $sol->cedula}}</td>
									<td colspan="2">{{$sol->nombres}}</td>
									<td>{{ $sol->beneficio}} {{$sol->dcategoria}}</td>
                                    <td align="right"><?php setlocale(LC_MONETARY, 've_BSs');
													echo money_format('%i', $sol->monto) . "\n";?></td>
                                    <td align="right"><?php echo money_format('%i', $sol->monto_retroactivo) . "\n";?></td>
								</tr>
							</thead>
							<?php $i=1; ?>
							@endforeach
						</table>
						<div id="sampleTable_paginate" class="dataTables_paginate paging_simple_numbers">
										</div>
					</div>
				</div>
			</div>

		</div>

@stop		