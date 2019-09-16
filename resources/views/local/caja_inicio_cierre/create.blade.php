@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Apertura y cierre de caja</h3>
		</div>
	</div>
	@if($caja_abierta == false)
			{!!Form::open(array('url'=>'local/caja_inicio_cierre','method'=>'POST','autocomplete'=>'off','files'=>'true')) !!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Dinero para apertura de caja</label>
				<input type="text" id='dinero_inicio' name="dinero_inicio" required value="{{old('dinero_inicio')}}" class="form-control" placeholder="¿Con cuanto dinero esta realizando la apertura de caja?">
			</div>
		</div>		
		
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Crear</button>
				<a href="{{ url('local/caja_inicio_cierre')}}"><button class="btn btn-danger" type="button">Cancelar</button></a>
			</div>
		</div>
	</div>		
		{!! Form::close() !!}
	
	@else
		<h4> Ya existe una apertura de caja activa</h4>
		<p> Debe cerrar esa apertura de caja para poder abrir una nueva apertura de caja  <p>
		<a href="{{ url('local/caja_inicio_cierre')}}">
		<button class="btn btn-warning" type="button">Ir a cerrar apertura</button></a>
	@endif

	@push('scriptsForm')
	<script>
	$(document).ready(function(){
		$("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    	});

		$('#dinero_inicio').on('keyup',function(){
			// When user select text in the document, also abort.
			var selection = window.getSelection().toString();
			if ( selection !== '' ) {
				return;
			}
			// Get the value.
			var input = $(this).val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt( input, 10 ) : 0;
			$(this).val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString('es-CL');
			});
		});

		$('form').on( "submit", function( event ) {
			var input2 = $('#dinero_inicio').val();
			input2 = input2.replace(/[($)\s\._\-]+/g, '');
			$('#dinero_inicio').val(input2);
		});
	});
	
	</script>
	@endpush

@endsection