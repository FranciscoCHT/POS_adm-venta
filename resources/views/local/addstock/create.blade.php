@extends('layouts.admin')

@section('contenido')
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Agregar Stock Rapido</h3>
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
			{!!Form::open(array('url'=>'local/add-stock','method'=>'POST','autocomplete'=>'off')) !!}
			{{Form::token()}}

	<div class="row">

		<div class=""><!-- SE PUEDE QUITAR LA CLASE PARA UNA MEJOR VISUALIZACION -->
			<div class="panel-body">
				<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12">
					<div class="form-group">
					<label>Producto</label>
					<select name="producto_id" class="form-control selectpicker" autofocus title="Buscar Producto..." data-size='6' id="producto_id" data-live-search="true">
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
						<button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
					</div>
				</div>

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Opciones</th>
							<th>Producto</th>
							<th>Cantidad</th>
							
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
				<a href="{{ url('local/add-stock')}} "><button class="btn btn-danger" type="button">Cancelar</button></a>
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
	});
	var cont=0;
	
	function agregar(){
		producto_id = $("#producto_id").val();
		producto = $("#producto_id option:selected").text();
		cantidad = $("#cantidad").val();
		
		
			if( producto_id!="" && cantidad!="" && cantidad>0 )
			{
				var fila=
				'<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="producto_id[]" value="'+producto_id+'">'+producto+'</td><td><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td></tr>';                                                             
				cont++;
				limpiar();	
				evaluar();
				$("#detalles").append(fila);
			}
			else
			{
				alert('Error al ingresar el detalle de stock, revise los datos');
			}
		
	}
	function limpiar(){
		$("#cantidad").val("");
		$("#producto_id").selectpicker('val','');
        $("#producto_id option").prop('selected',false);
        $("#producto_id").focus();
		
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