@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Proveedores
			<a href="proveedor/create"><button class="btn btn-success">Nuevo</button></a>
			</h3>
			@include('local.proveedor.search')
		</div>
	</div>

	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Empresa</th>
						<th>Nombre</th>
						<th>Descripcion</th>
						<th>Telefono</th>
						<th>Correo</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>

					@foreach ($proveedores as $proveedor) 
					<tr>
						<td>{{$proveedor->empresa}}</td>
						<td>{{$proveedor->nombre}}</td>
						<td>{{$proveedor->descripcion}}</td>
						<td>{{$proveedor->telefono}}</td>
						<td>{{$proveedor->correo}}</td>
						<td>{{$proveedor->estado}}</td>
						
						<td>
							<a href="{{URL::action('ProveedorController@edit',$proveedor->id)}}"><button class="btn btn-info">Editar</button></a>
							<!--<a href="" data-target="#modal-delete-{{$proveedor->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>-->
							{!! Form::open(array('action'=>array('ProveedorController@destroy',$proveedor->id),'method'=>'DELETE')) !!}
							<button type="submit" class="btn btn-danger ">Eliminar</button>
							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$proveedores->render()}}
		</div>
	</div>

@endsection