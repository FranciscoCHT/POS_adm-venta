@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado Aperturas y cierre de caja
			</h3>
			
			<br><br>
			@if($searchText != '')
			<h4>Palabra Buscada: <b>{{$searchText}}</b>	</h4>
			@endif
			@include('local.caja_inicio_cierre.search')
		</div>
	</div>

	<div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead>
						<th>Fecha Apertura</th>
						<th>Fecha de Cierre</th>
						<th>Dinero de Apertura</th>
						<th>Dinero de Cierre</th>
						<th>Estado</th>
						<th>Termino</th>
						<th>Movimiento</th>
					</thead>
					@foreach ($cajas_inicio_cierre as $caja_inicio_cierre) 
					<tr>
						
						<td>{{$caja_inicio_cierre->fecha_inicio}}</td>
						<td>
						@if($caja_inicio_cierre->fecha_cierre == null)
						Aún no has cerrado caja
						@else
						{{$caja_inicio_cierre->fecha_cierre}} 
						@endif
						</td>
						<td>{{number_format($caja_inicio_cierre->dinero_inicio,0,',','.') }}</td>
						<td>
						@if($caja_inicio_cierre->dinero_cierre == null)
						Aún no has cerrado caja
						@else
						{{ number_format($caja_inicio_cierre->dinero_cierre,0,',','.') }} 
						@endif
						</td>
						<td>
						@if($caja_inicio_cierre->estado == 1)
						Caja abierta
						@else
						Caja cerrada
						@endif
						</td>		
						<td> 
						@if($caja_inicio_cierre->estado != 0)
						<a href="{{URL::action('CajaInicioCierreController@edit',$caja_inicio_cierre->id)}}"><button class="btn btn-danger">Cerrar Caja</button></a>	
						@else
						<a href="{{URL::action('CajaInicioCierreController@edit',$caja_inicio_cierre->id)}}"><button class="btn btn-success">Corregir</button></a>
						@endif
						</td>
						<td> 
						<a href="{{URL::action('CajaInicioCierreController@movimiento',$caja_inicio_cierre->id)}}"><button class="btn btn-success">Ver</button></a>   
						</td>
					</tr>
					@endforeach
				</table>
			</div>
			{{$cajas_inicio_cierre->render()}}
		</div>
	</div>

@endsection