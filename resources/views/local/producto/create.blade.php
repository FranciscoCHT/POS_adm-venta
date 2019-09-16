@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Producto</h3>
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
			{!!Form::open(array('url'=>'local/producto','method'=>'POST','autocomplete'=>'off','files'=>'true')) !!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre del producto. ej: Salsa de tomates">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion"  value="{{old('descripcion')}}" class="form-control" placeholder="descripcion del producto. ej: 250 gr Pomarola">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Categoria</label>
				<select name="categoria_id" class="form-control">
					@foreach ($categorias as $categoria)
						<option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<input type="number" name="stock"  value="{{old('stock')}}" class="form-control" placeholder="stock del producto. Solo numeros" min='0'>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="cod_barra">Código Barra</label>
				<input type="text" name="cod_barra"  value="{{old('cod_barra')}}" class="form-control" placeholder="Código de barra del producto..">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="precio">Precio Venta</label>
				<input id="precio" type="text" name="precio" required value="{{old('precio')}}" 
				class="form-control" placeholder="Precio del producto.."
				maxlength="9">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<input type="file" name="imagen"  class="form-control" >
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

	(function($, undefined) {
	"use strict";
	// When ready.
	$(function() {
		var $form = $( "form" );
		var $input = $form.find( "#precio" );
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
	})(jQuery);
	
	</script>

	@endpush
@endsection