@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Agregar Egreso Rapido</h3>
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
			{!!Form::open(array('url'=>'local/egreso','method'=>'POST','autocomplete'=>'off')) !!}
			{{Form::token()}}

	<div class="row">

		<div class=""><!-- SE PUEDE QUITAR LA CLASE PARA UNA MEJOR VISUALIZACION -->
			<div class="panel-body">
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<label for="monto">Monto(dinero) </label>
						<input type="text" name="monto" id="monto"  class="form-control" placeholder="Ingrese cantidad..." min='0'>
					</div>
				</div>

				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					<div class="form-group">
						<label for="comentario">Comentario </label>
						<input type="text" name="comentario" id="comentario"  class="form-control" placeholder="Ingrese comentario...">
					</div>
				</div>
				
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
					</div>
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Opciones</th>
							<th>Monto(dinero)</th>
							<th>Comentario</th>
						</thead>
						<tfoot>
							<tr>
								<th  colspan="3"> </th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
			<div class="form-group">
				<input name="_token" value="{{csrf_token()}}" type="hidden"></input>
				<button class="btn btn-primary" type="submit">Guardar</button>
				<a href="{{ url('local/egreso')}} "><button class="btn btn-danger" type="button">Cancelar</button></a>
			</div>
		</div>
	</div>		
			
			
			{!! Form::close() !!}
@push('scripts')
	<script>
	$(document).ready(function(){
		$("#bt_add").click(function(){
			agregar();
		});
		$("form").keypress(function(e) {
			if (e.which == 13) {
				return false;
			}
		});
		//Para formatear el numero del input precio unitario
		$('input[id=monto]').on('keyup',function(){
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
			var input = $(this).val();
			var input = input.replace(/[\D\s\._\-]+/g, "");
			input = input ? parseInt( input, 10 ) : 0;
			$this.val( function() {
				return ( input === 0 ) ? "" : input.toLocaleString('es-CL');
			} );
		});
	});
	var cont=0;
	
	function agregar(){
		monto = $("#monto").val();
		monto = monto.replace(/[($)\s\._\-]+/g, '');
		comentario = $("#comentario").val();
		
			if( monto!="" && monto>0 )
			{
				var fila=
				'<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="monto[]" value="'+monto+'">'+new Intl.NumberFormat('es-CL').format(monto)+'</td><td><input type="hidden" name="comentario[]" value="'+comentario+'">'+comentario+'</td></tr>';                                                             
				cont++;
				limpiar();	
				evaluar();
				$("#detalles").append(fila);
			}
			else
			{
				alert('Error al ingresar el monto , revise los datos');
			}
	}
	function limpiar(){
		$("#comentario").val("");
		$("#monto").val("");
        $("#monto").focus();
		
	}
	function evaluar(){
		if(cont> 0)
		{
			$("#guardar").show();
		}
		else
		{
			$("#guardar").hide();
		}
	}
	function eliminar(index){
		
		$("#fila"+index).remove();
		evaluar();
	}

	</script>

@endpush
@endsection