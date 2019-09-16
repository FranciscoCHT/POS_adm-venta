
@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Datos de Empresa</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{$error}}</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
			{!!Form::model($empresa,['method'=>'PATCH','route'=>['empresa.update',$empresa->id],'files'=>'true']) !!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{$empresa->nombre}}" class="form-control" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="tipo">Tipo</label>
				<input type="text" name="tipo"  value="{{$empresa->tipo}}" class="form-control" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Direccion</label>
				<input type="text" name="direccion"  value="{{$empresa->direccion}}" class="form-control"  >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="razon_social">Razón Social</label>
				<input type="text" name="razon_social"  value="{{$empresa->razon_social}}" class="form-control" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="comuna">Comuna</label>
				<input type="text" name="comuna" required value="{{$empresa->comuna}}" class="form-control">
			</div>
		</div>
		<!--<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<input type="file" name="imagen"  class="form-control" >
			</div>
		</div>-->
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Editar</button>
				<a href="{{ url('local/empresa')}}"><button class="btn btn-danger" type="button">Cancelar</button></a>
			</div>
		</div>
	</div>		
			
		{!! Form::close() !!}
@endsection