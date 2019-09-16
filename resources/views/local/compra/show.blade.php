@extends('layouts.admin')

@section('contenido')
	

	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="proveedor">Proveedor</label>
				<p>{{$compra->empresa}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="numero_compra">Número Documento</label>
				<p>{{$compra->numero_documento}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="iva">Iva</label>
				<p>{{$compra->iva}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="total_compra">Total </label>
				<p>$ <?php echo number_format($compra->total_compra,0,',','.') ?></p>
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

				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Precio</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<tr>
								<th colspan="3" style="text-align:right"><h4>Total Neto:</h4></th>
								<th><h4 id="total">$ <?php echo number_format($neto,0,',','.') ?></h4></th>
							</tr>
							<tr>
								<th colspan="3" style="text-align:right"><h4>Total Bruto:</h4></th>
								<th><h4 id="total">$ <?php echo number_format($compra->total_compra,0,',','.') ?></h4></th>
							</tr>
						</tfoot>
						<tbody>
							@foreach($detalles as $detalle)
							<tr>
								<td>{{$detalle->producto}}</td>
								<td>{{$detalle->cantidad}}</td>
								<td>$<?php echo number_format($detalle->precio,0,',','.') ?></td>
								<td>$<?php echo number_format($detalle->total_linea,0,',','.') ?></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				
				</div>

			</div>
		</div>

	
	</div>		
			
@endsection