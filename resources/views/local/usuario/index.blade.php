@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Usuarios
			<a href="usuario/create"><button class="btn btn-success">Nuevo</button></a>
			</h3>
			@include('local.usuario.search')
		</div>
	</div>

	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Nombre</th>
						<th>Apellido</th>
						<th>Rut</th>
						<th>Rol</th>
						<th>Telefono</th>
						<th>Email</th>
						<th>Opciones</th>
					</thead>

					@foreach ($usuarios as $usuario) 
					<tr>
						<td>{{$usuario->nombre}}</td>
						<td>{{$usuario->apellido}}</td>
						<td>{{$usuario->rut}}</td>
						<td>{{$usuario->rol}}</td>
						<td>{{$usuario->telefono}}</td>
						<td>{{$usuario->email}}</td>
						<td>
							<a href="{{URL::action('UsuarioController@edit',$usuario->id)}}"><button class="btn btn-info">Editar</button></a>
							
							{!! Form::open(array('action'=>array('UsuarioController@destroy',$usuario->id),'method'=>'DELETE')) !!}
							<button type="submit" class="btn btn-danger ">Eliminar</button>
							{{Form::close()}}
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$usuarios->render()}}
		</div>
	</div>

@endsection