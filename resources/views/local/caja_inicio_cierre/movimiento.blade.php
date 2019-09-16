@extends('layouts.admin')

@section('contenido')
	
	<h3> Productos vendidos a la fecha  <b>{{$caja_inicio_cierre->fecha_inicio}}</b></h3>
	<h3> Dinero de Apertura: <b>{{$caja_inicio_cierre->dinero_inicio}}</b> Dinero de Cierre: @if($caja_inicio_cierre->dinero_cierre ==null)
	<b>Aun no has cerrado caja</b>
	@else
	 <b>{{$caja_inicio_cierre->dinero_cierre}}</b>
	@endif
	</h3>
	<div class="row">
		<div class=""><!-- SE PUEDE QUITAR LA CLASE PARA UNA MEJOR VISUALIZACION -->
			<div class="panel-body">
				<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
					<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
						<thead style="background-color:#A9D0F5">
							<th>Producto</th>
							<th>Cantidad</th>
							<th> Total Venta en Precio de Productos</th>
						</thead>
						<tbody>
							@for($i=0;$i<$cantproducto;$i++)
							<tr>
								<td>{{$productoNombre[$i]->nombre}}</td>
								<td>{{$cantidad_producto[$i]}}</td>
								<td> {{$total_precio_producto[$i]}}</td>
							</tr>
							@endfor
						</tbody>
						<td></td>
						<td></td>
						<td><b>Total: {{$total_global}}</b></td>
					</table>
				
				</div>

			</div>
		</div>

	
	</div>		
			
@endsection