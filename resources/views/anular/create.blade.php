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
		<h1><i class="fa fa-dashboard"></i> Eliminar Solicitudes de Beneficio en Masa</h1>

	</div>
	<ul class="app-breadcrumb breadcrumb side">
		<li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
		<li class="breadcrumb-item active"><a href="{{ route('anular.index') }}">Atrás</a></li>
	</ul>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="tile">

			<form class="row" name="form1" method="post" action="{{route ('anular.store')}}" accept-charset="UTF-8">
				<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />

				<div class="form-group col-md-1">
					<label class="control-label">Código</label>
					<input class="form-control" type="text" name="beneficio_id" id="beneficio_id" value="{{ $beneficio_id }}" readonly="">
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Beneficio</label>
					<input type="text" class="form-control" value="{{ $beneficio}}" disabled="">	
				</div>

				<div class="form-group col-md-2">
					<label class="control-label">Nómina</label>
					<input class="form-control" type="text" name="tipo_nomina" id="tipo_nomina" placeholder="Nómina" maxlength="12" value="{{ $nomina }}" readonly="">
					
				</div>
				<div class="form-group col-md-2">
					<label class="control-label">Fecha Registro</label>
					<input class="form-control datepicker" type="text" name="fecha_registro" id="fecha_registro" placeholder="Fecha Tramite" maxlength="12" value="{{$fecha_registro}}" readonly="">
				</div>


				<div class="form-group col-md-2">
					<label class="control-label">Fecha Tramite</label>
					<input class="form-control datepicker" type="text" name="fecha_tramite" id="fecha_tramite" placeholder="Fecha Tramite" maxlength="12" value="{{$fecha_tramite}}" readonly="">
				</div>

				<div class="tile-footer">
					<button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Eliminar</button>
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
								<th>Monto</th>
								<th>Descripcion</th>

								

							</tr>
						</thead>
						<?php 
						   $i=1; 
                           $ano=date("Y");
                           $vencimiento = $ano."-12-31";
						?>
						@foreach($solicitud as $sol)
						<tr>
							<td>{{ $i }}</td>
							<td>{{ $sol->cedula }}</td>
							<td colspan="2">{{ $sol->nombres }}</td>
							<td>{{ $sol->dcategoria }}</td>
							<td>{{ $sol->monto }} </td>
							<td>{{ $sol->descripcion }}</td>
							<?php $i++; ?>
						</tr>
						@endforeach
							
					</table>
					<div id="sampleTable_paginate" class="dataTables_paginate paging_simple_numbers">
						
					</div>
				</div>
			</div>
		</div>

	</div>
	@endsection