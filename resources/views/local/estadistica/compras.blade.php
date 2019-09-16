@extends('layouts.admin')

@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Estadistica respecto a Compras
			</h3>
		</div>
	</div>
	
	{!! Form::open(array('url'=>'local/estadistica/compra','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}

	<div class="row">
		<!--<div class="form-group">
			<div class="input-group">
				<input type="text" class="form-control" name="searchText" placeholder="Buscar.." value="{{$searchText}}">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-primary">Buscar</button>
				</span>
			</div>
		</div>-->
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="fecha_inicio">Fecha Inicio</label>
				<input type="date" name="fecha_inicio" value="" class="form-control" >
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="fecha_termino">Fecha Término</label>
				<input type="date" name="fecha_termino"  value="" class="form-control" >
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label style="color:white"> x</label><br>
				<button class="btn btn-primary" type="submit">Buscar</button>
			</div>
			</div>
		</div>
	</div>
	

	{{Form::close()}}

	<!-- Contenido de  --> 
	<div class="row">
      <div class="col-md-6"> 
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Cantidad de compra Por Día($)</h3>
            
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="barChart" style="height:230px"></canvas>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box --> 
      </div>
      <div class="col-md-6">
        <!-- BAR CHART -->
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Dinero invertido en compra a Proveedores</h3>
           
          </div>
          <div class="box-body">
            <div class="chart">
              <canvas id="barChart2" style="height:230px"></canvas>
            </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </div><!-- col-md-6 -->
      
	</div><!-- /.row (main row) -->
	
	@push('scripts')
    <script>
      $(function(){
      
      var compras = <?php echo json_encode($compras); ?>;
      //console.log(producto_compra);
      var fechas=[];
      var gastos=[];
      for (var i in compras) 
      {
          fechas.push(compras[i].fecha_compra);
          gastos.push(compras[i].total);
      }
      var barChartData = {
		  //labels: producto,
		  labels: fechas,
          datasets: [
            {
              label: "Monto gastado en el dia",
              fillColor: "rgba(210, 214, 223, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: gastos
            }
          ]
      };
      
      var barChartCanvas = $("#barChart").get(0).getContext("2d");
      var barChart = new Chart(barChartCanvas);
      /*barChartData.datasets[1].fillColor = "#00a65a";
      barChartData.datasets[1].strokeColor = "#00a65a";
      barChartData.datasets[1].pointColor = "#00a65a";*/
      var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      };
        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
    });
    </script>
	@endpush
@endsection