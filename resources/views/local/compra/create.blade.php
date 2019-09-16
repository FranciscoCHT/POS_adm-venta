@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Compra</h3>
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
			{!!Form::open(array('url'=>'local/compra','method'=>'POST','autocomplete'=>'off')) !!}
			{{Form::token()}}

	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="proveedor">Proveedor</label>
				
				<select name="proveedor_id" id="proveedor_id" class="form-control selectpicker" data-live-search="true">
				@foreach($proveedores as $proveedor)
				<option value="{{$proveedor->id}}">{{$proveedor->empresa}}</option>
				@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="numero_documento">Número Documento</label>
				<input type="text" name="numero_documento" required value="{{old('numero_documento')}}" class="form-control" placeholder="Número documento...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="codigo_barra">Codigo Barra</label>
				<input type="number" name="codigo_barra" value="{{old('codigo_barra')}}" class="form-control" placeholder="Codigo Barra...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="tipo_documento">Tipo Documento</label>
				<select name="tipo_documento" id="tipo_documento" class="form-control selectpicker" data-live-search="true">
					<option value="Factura">Factura</option>
					<option value="Boleta">Boleta</option>
					<option value="Guia Despacho">Guia de Despacho</option>
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="iva">Impuesto</label>
				<input type="number" name="iva" id="iva" required value="{{old('iva')}}" class="form-control" placeholder="Ingrese el Iva...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="total_compra">Total de la Compra</label>
				<input type="text" name="total_compra" id="total_compra" required value="{{old('total_compra')}}" class="form-control" placeholder="Ingrese total de la compra...">
			</div>
		</div>
		<!--<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="fecha_compra">Fecha</label>
				<input type="text" name="fecha_compra"  value="{{old('fecha_compra')}}" class="form-control" placeholder="Fecha de la compra...">
			</div>
		</div>-->
	</div>
	<div class="row">

		<div class="panel panel-primary"><!-- SE PUEDE QUITAR LA CLASE PARA UNA MEJOR VISUALIZACION -->
			<div class="panel-body">
				<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					<div class="form-group">
					<label>Producto</label>
					<select name="producto_id" class="form-control selectpicker" data-size='6' id="producto_id" data-live-search="true">
						@foreach($productos as $producto)
						<option value="{{$producto->id}}">{{$producto->producto}}</option>
						@endforeach
					</select>
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<label for="cantidad">Cantidad </label>
						<input type="number" name="cantidad" id="cantidad"  class="form-control" placeholder="Ingrese cantidad..." min='0'>
					</div>
				</div>
				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<label for="precio">Precio Unitario Neto</label>
						<input type="text" name="precio"  id="precio" class="form-control" placeholder="Ingrese precio..." >
					</div>
				</div>

				<div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
					<div class="form-group">
						<label for="total_linea">Total Neto </label>
						<input type="text" name="total_linea"  id="total_linea" class="form-control" placeholder="Ingrese total ..." min='0'>
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
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Precio</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<tr>
								<th  colspan="4" style="text-align:right"><h4>TOTAL NETO</h4></th>
								<th><h4 id="total">$ 0</h4></th>
							</tr>
							<tr>
								<th  colspan="4" style="text-align:right"><h4>Impuesto</h4></th>
								<th><h4 id="iva_total">$ 0</h4></th>
							</tr>
							<tr>
								<th colspan="4" style="text-align:right"><h4>TOTAL BRUTO(NETO+Impuesto)</h4></th>
								<th><h4 id="total_iva">$ 0</h4></th>
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
				<a href="{{ url('local/compra')}} "><button class="btn btn-danger" type="button">Cancelar</button></a>
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
		$("form").on('submit',function(){

		});
		$("form").on( "submit", function( event ) {
			var input3 = $('#total_compra').val();
			input3 = input3.replace(/[($)\s\._\-]+/g, '');
			$('#total_compra').val(input3);
		});
		//Formatear el input total_compra 
		$('input[id=total_compra]').on('keyup',function(){
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
		});
		//Para formatear el numero del input precio unitario
		$('input[id=precio]').on('keyup',function(){
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
		});
		$("input[id=precio]").blur(function(){
			sumar();
		});
		$("input[id=cantidad]").blur(function(){
			sumar();
		});

	});
	var cont=0;
	total=0;
	iva=0;
	total_iva=0;
	subtotal=[];
	function agregar(){
		producto_id = $("#producto_id").val();
		producto = $("#producto_id option:selected").text();
		cantidad = $("#cantidad").val();
		precio = $("#precio").val();
		precio = precio.replace(/[($)\s\._\-]+/g, '');
		total_linea = $("#total_linea").val();
		total_linea = total_linea.replace(/[($)\s\._\-]+/g, '');
		porc_iva = $("#iva").val();
		if(porc_iva !== ''){
			if( producto_id!="" && cantidad!="" && cantidad>0 && precio!="" && total_linea!="")
			{
				subtotal[cont]=(cantidad*precio);
				total=total+subtotal[cont];
				iva= total*(porc_iva/100);
				total_iva=total+iva;

				var fila=
				'<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td><td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td><input type="hidden" name="precio[]" value="'+precio+'">'+new Intl.NumberFormat('es-CL').format(precio)+'</td><td><input type="hidden" name="total_linea[]" value="'+total_linea+'">'+new Intl.NumberFormat('es-CL').format(total_linea)+'</td></tr>';                                                             
				cont++;
				limpiar();
				/*$("#total").html("$ "+total);
				$("#iva_total").html("$ "+iva);
				$("#total_iva").html("$ "+total_iva);*/
				//Nuevo
				$("#total").html("$ "+new Intl.NumberFormat('es-CL').format(total));
				$("#iva_total").html("$ "+new Intl.NumberFormat('es-CL').format(iva));
				$("#total_iva").html("$ "+new Intl.NumberFormat('es-CL').format(total_iva));
				evaluar();
				$("#detalles").append(fila);
			}
			else
			{
				alert('Error al ingresar el detalle de la compra, revise los datos del producto');
			}
		}else{
			alert('Introducir valor del IVA');
		}
		
	}
	function limpiar(){
		$("#cantidad").val("");
		$("#precio").val("");
		$("#total_linea").val("");
	}
	function evaluar(){
		if(total > 0)
		{
			$("#guardar").show();
		}
		else
		{
			$("#guardar").hide();
		}
	}
	function eliminar(index){
		total=total-subtotal[index];
		iva= total*0,19;
		total_iva=total+iva;
		$("#total").html("$ "+new Intl.NumberFormat('es-CL').format(total));
		$("#iva_total").html("$ "+new Intl.NumberFormat('es-CL').format(iva));
		$("#total_iva").html("$ "+new Intl.NumberFormat('es-CL').format(total_iva));
		$("#fila"+index).remove();
		evaluar();

	}
	function sumar(){
		precio_set = $("#precio").val();
		precio_set = precio_set.replace(/[($)\s\._\-]+/g, '');
		//suma = $("#cantidad").val() * $("#precio").val();
		suma = $("#cantidad").val() * precio_set;
		$('#total_linea').val(new Intl.NumberFormat('es-CL').format(suma));
	}

	</script>

@endpush
@endsection