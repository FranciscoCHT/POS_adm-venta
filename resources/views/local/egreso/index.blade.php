@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Egresos</h3>
			@if($caja)
				<a href="egreso/create">
					<button class="btn btn-success">Agregar Egreso</button>
				</a><br><br>
			@else
				<p><b>PARA PODER AGREGAR UN EGRESO AGIL, DEBE ABRIR UN INICIO DE CAJA </b></p>
			@endif
			@include('local.egreso.search')
		</div>
	</div>
	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Monto(Dinero)</th>
						<th>Comentario</th>
						<th>Fecha</th>
						<th>Usuario</th>
						<th>Opciones</th>
					</thead>
					@foreach ($egresos as $egreso) 
					<tr>
						<td> $ {{ number_format($egreso->monto,0,',','.') }}</td>
						<td>{{$egreso->comentario}}</td>
						<td>{{$egreso->fecha}}</td>
						<td>{{$egreso->vendedor}}</td>
						<td>
							{!! Form::open(array('action'=>array('EgresoController@destroy',$egreso->id),'method'=>'DELETE')) !!}
							<button type="submit" class="btn btn-danger ">Eliminar</button>
							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$egresos->render()}}
		</div>
	</div>

@endsection