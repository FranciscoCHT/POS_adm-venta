@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Stock Agregado
			</h3>
			@if($caja)
				<a href="add-stock/create">
					<button class="btn btn-success">Agregar Stock</button>
				</a><br><br>
			@else
				<p><b>PARA PODER AGREGAR UN STOCK AGIL, DEBE ABRIR UN INICIO DE CAJA </b></p>
			@endif
			@include('local.addstock.search')
		</div>
	</div>
	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Fecha</th>
						<th>Usuario</th>
						<th>Opciones</th>
					</thead>
					@foreach ($adds as $add) 
					<tr>
						<td>{{$add->producto}}</td>	
						<td>{{$add->cantidad}}</td>
						<td>{{$add->fecha}}</td>
						<td>{{$add->vendedor}}</td>
								
						<td>
							{!! Form::open(array('action'=>array('AddStockController@destroy',$add->id),'method'=>'DELETE')) !!}
							<button type="submit" class="btn btn-danger ">Eliminar</button>
							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$adds->render()}}
		</div>
	</div>

@endsection