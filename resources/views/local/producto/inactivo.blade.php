@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Productos Inactivos
			<a href="create"><button class="btn btn-success">Nuevo</button></a>
			</h3>
			<a href="{{ url('local/producto')}}"><button class="btn btn-warning">Activos</button></a>
			<br><br>
			@if($searchText != '')
			<h4>Palabra Buscada: <b>{{$searchText}}</b>	</h4>
			@endif
			@include('local.producto.search')
		</div>
	</div>

	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Imagen</th>
						<th>Nombre</th>
						<!--<th>Descripcion</th>-->
						<th>Categoria</th>
						<th>Stock</th>
						<th>codigo barra</th>
						<th>Precio</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($productos as $producto) 
					<tr>
						<td>
							<img src="{{asset('imagenes/productos/'.$producto->imagen)}}" alt='ok' height="90px" width="70px" class="img-thumbnail">
						</td>
						<td>{{$producto->nombre}}</td>
						<!--<td>{{$producto->descripcion}}</td>-->
						<td>{{$producto->categoria}}</td>
						<!-- <td> %ganancia </td>-->
						<td>{{$producto->stock}}</td>
						<td>{{$producto->cod_barra}}</td>
						<!--<td>{{$producto->precio}}</td>-->
						<td>$ <?php echo number_format($producto->precio,0,',','.') ?></td>
						<td>{{$producto->estado}}</td>
						
						<td>
							<a href="{{URL::action('ProductoController@edit',$producto->id)}}"><button class="btn btn-info">Editar</button></a>
							<a href="{{URL::action('ProductoController@activar',$producto->id)}}"><button class="btn btn-danger">Activar</button></a>
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$productos->render()}}
		</div>
	</div>

@endsection