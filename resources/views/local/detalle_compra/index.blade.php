@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Consulta de Productos
			</h3>
			@include('local.detalle_compra.search')
		</div>
	</div>

	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Imagen</th>
						<th>Nombre</th>
						<th>Codigo barra</th>
						<th>Fecha Compra</th>
						<th>Proveedor</th>
						<th>Iva</th>
						<th>Precio Compra</th>
						<th>Precio + Iva</th>
						<th>Precio Venta</th>
						<th>Ganancia</th>
						<th>% Ganancia</th>
						
					</thead>
					@foreach ($detalles as $detalle) 
					<tr>
						<td>
							<img src="{{asset('imagenes/productos/'.$detalle->imagen)}}" alt='ok' height="90px" width="70px" class="img-thumbnail">
						</td>
						<td>{{$detalle->nombre}}</td>
						<td>{{$detalle->cod_barra}}</td>
						<td>{{$detalle->fecha_compra}}</td>
						<td>{{$detalle->empresa}}</td>
						<td>{{$detalle->iva}}</td>
						<td>$ <?php echo number_format($detalle->precio,0,',','.') ?></td>
						<td>$ <?php echo number_format(($detalle->precio)*($detalle->iva/100) + $detalle->precio,0,',','.') ?></td>
						<td>$ <?php echo number_format($detalle->precio_venta,0,',','.') ?></td>
						<td>$ <?php echo number_format($detalle->precio_venta -  ((($detalle->precio)*($detalle->iva/100)) + $detalle->precio ),0,',','.') ?></td>
						<td><?php echo number_format((($detalle->precio_venta - (($detalle->precio*($detalle->iva/100))+$detalle->precio))*100/$detalle->precio_venta ),0,',','.') ?>%</td>
						
					</tr>
					@endforeach
				</table>
			</div>
			
		</div>
	</div>

@endsection