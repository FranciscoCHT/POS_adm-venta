@extends('layouts.admin')
@section('contenido')

	<div class= row>
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Panel de Inicio
			</h3>
		</div>
	</div>
	<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>$ {{ number_format($dinero_caja,0,',','.') }}</h3>
              <p>Dinero Apertura</p>
            </div>
            <div class="icon">
              <i class="fa fa-money" aria-hidden="true"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>$ <?php echo number_format($dinero_entrante,0,',','.')?> </h3>
              <p>Dinero Entrante</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>           
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>$ {{ number_format($egreso,0,',','.') }}</h3>
              <p>Egreso Agil</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div> 
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>$ <?php echo number_format($dinero_saliente,0,',','.')?></h3>
              <p>Egreso por documento</p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        
    </div><!--  ./row -->

	  <div class="row">
      <div class="col-md-6"> 
         
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Gastado en Producto(neto)</h3>
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
            <h3 class="box-title">Compra en Proveedores</h3>
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
      
      var producto_compra = <?php echo json_encode($producto_compra); ?>;
      var producto=[];
      var gasto=[];
      for (var i in producto_compra) 
      {
          producto.push(producto_compra[i].nombre);
          gasto.push(producto_compra[i].total);
      }
      var barChartData = {
          labels: producto,
          datasets: [
            {
              label: "Monto de compra productos",
              fillColor: "rgba(210, 214, 223, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: gasto
            }
          ]
      };
      var compra = <?php echo json_encode($compra_pro); ?>;
      var proveedor=[];
      var inversion=[];
      for (var i in compra) 
      {
          proveedor.push(compra[i].empresa);
          inversion.push(compra[i].total_compra);
      }
      var barChartData2 = {

          labels: proveedor,
          datasets: [
            {
              label: "Monto Compra Proveedores",
              fillColor: "rgba(210, 214, 222, 1)",
              strokeColor: "rgba(210, 214, 222, 1)",
              pointColor: "rgba(210, 214, 222, 1)",
              pointStrokeColor: "#c1c7d1",
              pointHighlightFill: "#fff",
              pointHighlightStroke: "rgba(220,220,220,1)",
              data: inversion
            }
          ]
      };
 
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
        barStrokeWidth: 1,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 10,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      };

      var barChartCanvas = $("#barChart").get(0).getContext("2d");
      var barChart = new Chart(barChartCanvas);
      barChartOptions.datasetFill = false;
      barChart.Bar(barChartData, barChartOptions);

      //Creación del segundo Bar Chart
      var barChartCanvas2 = $("#barChart2").get(0).getContext("2d");
      var barChart2 = new Chart(barChartCanvas2);
      /*barChartData2.datasets[1].fillColor = "#00a65a";
      barChartData2.datasets[1].strokeColor = "#00a65a";
      barChartData2.datasets[1].pointColor = "#00a65a";*/
      barChart2.Bar(barChartData2, barChartOptions);
    });
    </script>

	@endpush

@endsection