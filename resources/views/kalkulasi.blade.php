@extends('adminlte::page')

@section('title', 'Data Training KNN Projek')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap-datepicker.min.css')}}">
@stop
@section('content_header')
    <li class="" style="list-style-type: none;">
      <h1>
       REPORT KLASIFIKASI DATA
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Hasil KNN</li>
      </ol>
    </li>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">          
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <h3>Proses Kalkulasi Dengan Nilai K = {{$k}}</h3>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
            
      
@stop
@section('js')
<script src="{{ asset('vendor/adminlte/bootstrap/js/bootstrap-datepicker.min.js') }}"></script>

@endsection