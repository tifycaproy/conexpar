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
<?php
$zmontob=0;
$zmontor=0;
$zcantidad=0;
?>

<div class="app-title">
	<div>
		<h1><i class="fa fa-dashboard"></i> Generar Reportes de Solicitud de Beneficio por Lapso</h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		
		<li class="breadcrumb-item active"><a href="{{ route('rptlapso.index') }}">Atrás</a></li>
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
					<label class="control-label">Desde</label>
					<input class="form-control" type="text" name="desde" id="desde" placeholder="Fecha Registro" maxlength="12" value="{{$desde}}" readonly="">
				</div>
				<div class="form-group col-md-2">
					<label class="control-label">Hasta</label>
					<input class="form-control datepicker" type="text" name="hasta" id="hasta" placeholder="Fecha Registro" maxlength="12" value="{{$hasta}}" readonly="">
				</div>
			</form>  
		</div>
				
			</div>	
			
		</div>	

		<div class="row">
			<div class="col-md-12">
				<div class="tile">
					<div class="tile-body">
				@if($tipol=='1')		
						<table class="table table-hover table-bordered" id="sampleTable">
							<thead>
								<tr>
									<th>Beneficio</th>
									<th>Categoria</th>
									<th>Cantidad</th>
                                    <th align="right">Monto</th>
                                    <th align="right">Retroactivo</th>
								</tr>
								@foreach($solicitud as $sol)
								<tr>
									<td>{{ $sol->beneficio}}</td>
									<td>{{ $sol->dcategoria}}</td>
									<td >{{$sol->cantidad}}</td>
									<td align="right"><?php setlocale(LC_MONETARY, 've_BSs');
													echo money_format('%i', $sol->montob) . "\n";?></td>
                                    <td align="right"><?php echo money_format('%i', $sol->montor) . "\n";?></td>
								</tr>
							</thead>
							<?php $i=1; 
							$zmontob = $zmontob + $sol->montob; 
							$zmontor = $zmontor + $sol->montor;
							$zcantidad = $zcantidad+ $sol->cantidad;?>
							@endforeach
								<tr>
									<td>Total</td>
									<td></td>
									<td ><b>{{$zcantidad}}</b></td>
									<td align="right"><b><?php setlocale(LC_MONETARY, 've_BSs');
													echo money_format('%i', $zmontob) . "\n";?></b></td>
                                    <td align="right"><b><?php echo money_format('%i', $zmontor) . "\n";?></b></td>
								</tr>
						</table>
						@endif
						@if($tipol=='2')
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

						@endif
						<div id="sampleTable_paginate" class="dataTables_paginate paging_simple_numbers">
										</div>
					</div>
				</div>
			</div>

		</div>

@stop		