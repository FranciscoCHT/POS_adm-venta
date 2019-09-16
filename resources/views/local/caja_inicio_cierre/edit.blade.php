@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Cierre de caja del dia </h3>
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
			
			{!!Form::model($caja_inicio_cierre,['method'=>'PATCH','route'=>['caja_inicio_cierre.update',$caja_inicio_cierre->id],'files'=>'true']) !!}
			{{Form::token()}}
	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="dinero_cierre">ingrese el dinero recaudado hoy</label>
				<input type="text" name="dinero_cierre" id="dinero_cierre" required value="{{$caja_inicio_cierre->dinero_cierre}}" class="form-control">
			</div>
		</div>		
		
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Cerrar Caja</button>
				<a href="{{ url('local/caja_inicio_cierre')}}"><button class="btn btn-danger" type="button">Cancelar</button></a>
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

		$('#dinero_cierre').on('keyup',function(){
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
			var input2 = $('#dinero_cierre').val();
			input2 = input2.replace(/[($)\s\._\-]+/g, '');
			$('#dinero_cierre').val(input2);
		});
	});

	
	
	
	</script>

	@endpush
@endsection