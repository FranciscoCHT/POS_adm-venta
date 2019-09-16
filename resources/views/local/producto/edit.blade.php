@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Producto: {{$producto->nombre}}</h3>
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
			{!!Form::model($producto,['method'=>'PATCH','route'=>['producto.update',$producto->id],'files'=>'true']) !!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{$producto->nombre}}" class="form-control">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" required value="{{$producto->descripcion}}" class="form-control" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Categoría</label>
				<select name="categoria_id" class="form-control">
					@foreach ($categorias as $categoria)
						@if($categoria->id == $producto->categoria_id)
						<option value="{{$categoria->id}}" selected>{{$categoria->nombre}}</option>
						@else
						<option value="{{$categoria->id}}" >{{$categoria->nombre}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<input type="text" name="stock"  value="{{$producto->stock}}" class="form-control" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="cod_barra">Código Barra</label>
				<input type="text" name="cod_barra"  value="{{$producto->cod_barra}}" class="form-control" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="precio">Precio Venta</label>
				<input type="text" name="precio" id='precio' 
				value="{{ number_format($producto->precio,0,',','.') }}" class="form-control" >
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<input type="file" name="imagen"  class="form-control" >
				@if(($producto->imagen) != "")
					<img src="{{asset('/imagenes/productos/'.$producto->imagen)}}" height="280px" width="280px">
				@endif
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<a href="{{ url('local/producto')}}"><button class="btn btn-danger" type="button">Cancelar</button></a>
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

	$(function() {
		var $form = $("form");
		var $input = $form.find( "#precio" );
		//var $input = $('#precio');
		$input.on( "keyup", function( event ) {
			// When user select text in the document, also abort.
			var selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}
			// When the arrow keys are pressed, abort.
			if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
				return;
			}
			var $this = $( this );
			// Get the value.
			var input = $this.val();
			//console.log(input);
			var input = input.replace(/[\D\s\._\-]+/g, "");
					input = input ? parseInt( input, 10 ) : 0;
					$this.val( function() {
						return ( input === 0 ) ? "" : input.toLocaleString('es-CL');
					} );
		} );
		/**
		* When Form Submitted
		**/
		$form.on( "submit", function( event ) {
			var input2 = $input.val();
			input2 = input2.replace(/[($)\s\._\-]+/g, '');
			$('#precio').val(input2);
		});
		
	});
	
	
	</script>

	@endpush
@endsection