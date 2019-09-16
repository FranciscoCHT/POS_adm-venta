@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Ventas
			</h3>
			@include('local.venta.search')
		</div>
	</div>

	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Vendedor</th>
						<th>Número Venta</th>
						<th>Fecha Venta</th>
						<th>Total</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($ventas as $venta) 
					<tr>
						<td>{{$venta->vendedor}}</td>
						<td>{{$venta->numero_venta}}</td>
						<td>{{$venta->fecha_venta}}</td>
						<td>$ <?php echo number_format($venta->precio_total,0,',','.') ?></td>
						<td> {{$venta->estado}}</td>
						
						<td>
							<a href="{{URL::action('VentaController@show',$venta->id)}}"><button class="btn btn-info">Detalles</button></a>
							{!! Form::open(array('action'=>array('VentaController@destroy',$venta->id),'method'=>'DELETE')) !!}
							<button type="submit" class="btn btn-danger ">Eliminar</button>
							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$ventas->render()}}
		</div>
	</div>

@endsection