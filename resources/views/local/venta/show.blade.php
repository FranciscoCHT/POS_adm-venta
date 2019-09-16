@extends('layouts.admin')

@section('contenido')
	

	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Vendedor</label>
				<p>{{$venta->vendedor}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Número Venta</label>
				<p>{{$venta->numero_venta}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Fecha Venta</label>
				<p>{{$venta->fecha_venta}}</p>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label >Total </label>
				<p><?php echo number_format($venta->precio_total,0,',','.') ?></p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="panel panel-primary"><!-- SE PUEDE QUITAR LA CLASE PARA UNA MEJOR VISUALIZACION -->
			<div class="panel-body">
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Producto</th>
							<th>Cantidad</th>
							<th>Precio Unitario</th>
							<th>Descuento</th>
							<th>Subtotal</th>
						</thead>
						<tfoot>
							<th colspan="4" style="text-align:right"><h4>Total:</h4></th>
							<th><h4 id="total">$ <?php echo number_format($venta->precio_total,0,',','.') ?></h4></th>
						</tfoot>
						<tbody>
							@foreach($detalles as $detalle)
							<tr>
								<td>{{$detalle->producto}}</td>
								<td>{{$detalle->cantidad}}</td>
								<td>{{$detalle->precio_unitario}}</td>
								<td>{{$detalle->descuento}}</td>
								<td><?php echo number_format($detalle->precio_linea,0,',','.') ?></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				
				</div>

			</div>
		</div>

	
	</div>		
			
@endsection