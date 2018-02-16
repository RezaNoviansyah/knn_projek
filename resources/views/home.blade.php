@extends('adminlte::page')

@section('title', 'Dashboard KNN Projek')

@section('content_header')
	<li class="" style="list-style-type: none;">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li class="active"><a href="{{URL::to('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-6 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$jumlah_data_latih}}</h3>

              <p>Jumlah Data Latih</p>
            </div>
            <div class="icon">
              <i class="fa fa-table fa-fw"></i>
            </div>
            <a href="{{URL::to('data_latih')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <div class="col-lg-6 col-xs-12">
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$jumlah_data_uji}}</h3>

              <p>Jumlah Data Uji</p>
            </div>
            <div class="icon">
              <i class="fa fa-table fa-fw"></i>
            </div>
            <a href="{{URL::to('data_uji')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
    </div>
    <div class="row">
    	<div class="col-lg-12 col-xs-12">
	    	<div class="box box-default">
		        <div class="box-header with-border">
		          <h3 class="box-title">Grafik FWI Januari 2015 - Desember 2016</h3>
		        </div>
		        <!-- /.box-header -->
		        <div class="box-body">
		          <div class="row">
		            <div class="col-md-8">
		              <div class="chart-responsive">
		                <canvas id="pieChart3" height="150"></canvas>
		              </div>
		              <!-- ./chart-responsive -->
		            </div>
		            <!-- /.col -->
		            <div class="col-md-4">
		              <ul class="chart-legend clearfix">
		                <li><i class="fa fa-circle-o text-aqua"></i> Rendah</li>
		                <li><i class="fa fa-circle-o text-green"></i> Sedang</li>
		                <li><i class="fa fa-circle-o text-yellow"></i> Tinggi</li>
		                <li><i class="fa fa-circle-o text-red"></i> Ekstrim</li>
		              </ul>
		            </div>
		            <!-- /.col -->
		          </div>
		          <!-- /.row -->
		        </div>
		        <!-- /.box-body -->
		        <div class="box-footer no-padding">
		          <ul class="nav nav-pills nav-stacked">
		            <li><a href="#">Rendah<span class="pull-right text-aqua">{{number_format(($jumlah_fwi_rendah/$jumlah_data_latih)*100,2)}}%</span></a></li>
		            <li><a href="#">Sedang<span class="pull-right text-green">{{number_format(($jumlah_fwi_sedang/$jumlah_data_latih)*100,2)}}%</span></a></li>
		            <li><a href="#">Tinggi<span class="pull-right text-yellow">{{number_format(($jumlah_fwi_tinggi/$jumlah_data_latih)*100,2)}}%</span></a></li>
		            <li><a href="#">Ekstrim<span class="pull-right text-red">{{number_format(($jumlah_fwi_ekstrim/$jumlah_data_latih)*100,2)}}%</span></a></li>
		          </ul>
		        </div>
	    	</div>
	    </div>
    </div>
    
@stop
@section('js')
<script src="{{ asset('vendor/adminlte/plugins/chartjs/Chart.min.js') }}"></script>
<script>
	//-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart3").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
      {
        value: {{$jumlah_fwi_rendah}},
        color: "#00c0ef",
        highlight: "#00c0ef",
        label: "Rendah"
      },
      
      {
        value: {{$jumlah_fwi_sedang}},
        color: "#00a65a",
        highlight: "#00a65a",
        label: "Sedang"
      },
      {
        value: {{$jumlah_fwi_tinggi}},
        color: "#f39c12",
        highlight: "#f39c12",
        label: "Tinggi"
      },
      {
        value: {{$jumlah_fwi_ekstrim}},
        color: "#f56954",
        highlight: "#f56954",
        label: "Ekstrim"
      },
    ];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
</script>
@endsection