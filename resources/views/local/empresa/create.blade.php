@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Crear Datos de Empresa</h3>
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
			{!!Form::open(array('url'=>'local/empresa','method'=>'POST','autocomplete'=>'off','files'=>'true')) !!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre de tu negocio. ej: Donde Juan">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="tipo">Tipo</label>
				<input type="text" name="tipo"  value="{{old('tipo')}}" class="form-control" placeholder="Que negocio es? ej: Minimarket">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Direccion</label>
				<input type="text" name="direccion"  value="{{old('direccion')}}" class="form-control" placeholder="Direccion de tu negocio" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="razon_social">Razón Social</label>
				<input type="text" name="razon_social"  value="{{old('razon_social')}}" class="form-control" placeholder="Nombre real de tu negocio. ej: almacen hermanos lazos SPA">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="comuna">Comuna</label>
				<input  type="text" name="comuna" required value="{{old('comuna')}}" 
				class="form-control" placeholder="Comuna o cuidad de tu negocio">
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
				<button class="btn btn-primary" type="submit">Crear</button>
				<a href="{{ url('local/empresa')}}"><button class="btn btn-danger" type="button">Cancelar</button></a>
			</div>
		</div>
	</div>		
			
		{!! Form::close() !!}
@endsection