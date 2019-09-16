@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Categorias Activas
			<a href="categoria/create"><button class="btn btn-success">Nueva</button></a>
			</h3>
			<a href="{{ url('local/categoria/inactivo')}}"><button class="btn btn-warning">Ver Inactivos</button></a>
			<br><br>
			@include('local.categoria.search')
		</div>
	</div>

	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						
						<th>Nombre</th>
						<th>Descripcion</th>
						<th>Sku</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($categorias as $categoria) 
					<tr>
						<td>{{$categoria->nombre}}</td>
						<td>{{$categoria->descripcion}}</td>
						<td>{{$categoria->sku}}</td>
						<td>{{$categoria->estado}}</td>
						<td>
							<a href="{{URL::action('CategoriaController@edit',$categoria->id)}}"><button class="btn btn-info">Editar</button></a>
							<!--<a href="" data-target="#modal-delete-{{$categoria->id}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>-->
							{!! Form::open(array('action'=>array('CategoriaController@destroy',$categoria->id),'method'=>'DELETE')) !!}
							<button type="submit" class="btn btn-danger ">Eliminar</button>
							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$categorias->render()}}
		</div>
	</div>

@endsection