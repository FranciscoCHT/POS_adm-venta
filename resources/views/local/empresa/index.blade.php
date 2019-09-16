@extends('layouts.admin')

@section('contenido')
    @if($empresa)
    <h2>Nombre: {{$empresa->nombre }}</h2>
    <a href="{{URL::action('EmpresaController@edit',$empresa->id)}}"><button class="btn btn-warning">Editar</button></a>
    <br><br>
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Tipo</label>
				<p>{{$empresa->tipo}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Dirección</label>
				<p>{{$empresa->direccion}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Razón Social</label>
				<p>{{$empresa->razon_social}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Comuna</label>
				<p>{{$empresa->comuna}}</p>
			</div>
		</div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Logo</label>
				<p>{{$empresa->logo}}</p>
			</div>
		</div>
	</div>
    @else
    <h2>Crear datos</h2>
    <a href="empresa/create"><button class="btn btn-success">Crear Datos</button></a>
    @endif
			
@endsection