@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Usuario:  {{$usuario->nombre}}</h3>
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

			{!!Form::model($usuario,['method'=>'PATCH','route'=>['usuario.update',$usuario->id]]) !!}
			{{Form::token()}}

	<div class="row">
		<div class="form-group">
			<label for="nombre" class="col-md-4 col-form-label text-md-right">Nombre</label>

			<div class="col-md-6">
				<input id="nombre" type="text" class="form-control{{ $errors->has('nombre') ? ' is-invalid' : '' }}" name="nombre" value="{{$usuario->nombre}}" required autofocus>

				@if ($errors->has('name'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('nombre') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group ">
			<label for="apellido" class="col-md-4 col-form-label text-md-right">{{ __('Apellido') }}</label>

			<div class="col-md-6">
				<input id="apellido" type="text" class="form-control{{ $errors->has('apellido') ? ' is-invalid' : '' }}" name="apellido" value="{{ $usuario->apellido}}" required>

				@if ($errors->has('apellido'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('apellido') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group ">
			<label for="rut" class="col-md-4 col-form-label text-md-right">{{ __('Rut') }}</label>

			<div class="col-md-6">
				<input id="rut" type="text" class="form-control{{ $errors->has('rut') ? ' is-invalid' : '' }}" name="rut" value="{{ $usuario->rut }}" required >

				@if ($errors->has('rut'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('rut') }}</strong>
					</span>
				@endif
			</div>
		</div>
		<div class="form-group ">
			<label for="rol" class="col-md-4 col-form-label text-md-right">{{ __('Rol') }}</label>

			<div class="col-md-6">
				<input id="rol" type="text" class="form-control{{ $errors->has('rol') ? ' is-invalid' : '' }}" name="rol" value="{{ $usuario->rol }}" required >

				@if ($errors->has('rol'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('rol') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group ">
			<label for="telefono" class="col-md-4 col-form-label text-md-right">{{ __('Telefono') }}</label>

			<div class="col-md-6">
				<input id="telefono" type="text" class="form-control{{ $errors->has('telefono') ? ' is-invalid' : '' }}" name="telefono" value="{{ $usuario->telefono }}" required >

				@if ($errors->has('telefono'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('telefono') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group ">
			<label for="email" class="col-md-4 col-form-label text-md-right">Correo</label>

			<div class="col-md-6">
				<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$usuario->email}}" required>

				@if ($errors->has('email'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('email') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group ">
			<label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>

			<div class="col-md-6">
				<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

				@if ($errors->has('password'))
					<span class="invalid-feedback" role="alert">
						<strong>{{ $errors->first('password') }}</strong>
					</span>
				@endif
			</div>
		</div>

		<div class="form-group">
			<label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirmar Contraseña</label>

			<div class="col-md-6">
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<button class="btn btn-danger" type="reset">Cancelar</button>
			</div>
		</div>
	</div>		
			
			
		{!! Form::close() !!}
	@push('scriptsForm')
	<script>
	$(document).ready(function(){
		$("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    	});
	});
	
	</script>

	@endpush
@endsection