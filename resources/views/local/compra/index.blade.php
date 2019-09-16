@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Compra
			<a href="compra/create"><button class="btn btn-success">Nuevo</button></a>
			</h3>
			@include('local.compra.search')
		</div>
	</div>
	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Número Documento</th>
						<th>Tipo Documento</th>
						<th>Codigo barra</th>
						<th>Fecha</th>
						<th>Proveedor</th>
						<th>Total</th>
						<th>Opciones</th>
					</thead>
					@foreach ($compras as $compra) 
					<tr>
						<td>{{$compra->numero_documento}}</td>
						<td>{{$compra->tipo_documento}}</td>
						<td>{{$compra->codigo_barra}}</td>
						<td>{{$compra->fecha_compra}}</td>
						<td>{{$compra->proveedor}}</td>	
						<td>$ <?php echo number_format($compra->total_compra,0,',','.') ?></td>			
						<td>
							<a href="{{URL::action('CompraController@show',$compra->id)}}"><button class="btn btn-info">Detalles</button></a>
							{!! Form::open(array('action'=>array('CompraController@destroy',$compra->id),'method'=>'DELETE')) !!}
							<button type="submit" class="btn btn-danger ">Eliminar</button>
							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$compras->render()}}
		</div>
	</div>

@endsection