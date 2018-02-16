@extends('adminlte::page')

@section('title', 'Data Training KNN Projek')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap-datepicker.min.css')}}">
@stop
@section('content_header')
    <li class="" style="list-style-type: none;">
      <h1>
        Hasil KNN
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Hasil KNN</li>
      </ol>
    </li>
@stop

@section('content')
@if (session('warning'))
    <div class="alert alert-danger data_notif">
        {{ session('warning') }}
    </div>
@endif
    <div class="row">
        <div class="col-xs-12">          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Hasil KNN</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if (Auth::check())
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-kalkulasi">
                Hitung Kalkulasi Data
              </button></a>
              @endif
              <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Suhu</th>
                  <th>Kelembapan</th>
                  <th>Curah Hujan</th>
                  <th>Kec. Angin</th>
                  <th>Nilai K</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data_hasil as $baris)
                <tr>
                  <td>{{$baris->suhu_uji}}</td>
                  <td>{{$baris->kelembapan_uji}}</td>
                  <td>{{$baris->hujan_uji}}</td>
                  <td>{{$baris->angin_uji}}</td>
                  <td>{{$baris->nilai_k}}</td>
                  <td align="center"><a href="{{url('hitung_knn')}}/{{$baris->id_uji}}/{{$baris->id_hasil}}"><button type="button" class="btn btn-primary mulai_knn">
                      Lihat Perhitungan KNN
                    </button></a></td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Suhu</th>
                  <th>Kelembapan</th>
                  <th>Curah Hujan</th>
                  <th>Kec. Angin</th>
                  <th>Nilai K</th>
                  <th>Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>

      <div class="modal fade" id="modal-kalkulasi">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('kalkulasi')}}">
            {!! csrf_field() !!}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Hitung Kalkulasi data Berdasarkan Nilai Uji K</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="">Masukkan Nilai K yang sudah di Ujikan</label>
                  <input type="text" class="form-control" name="nilai_k" id="" placeholder="Masukkan Nilai K">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Mulai Kalkulasi</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>
      
@stop
@section('js')
<script src="{{ asset('vendor/adminlte/bootstrap/js/bootstrap-datepicker.min.js') }}"></script>
<script>
  setTimeout(fade_out, 5000);

  function fade_out() {
    $(".data_notif").fadeOut().empty();
  }
</script>
<script>
  //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

  $(function () {
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true
    });
  });
</script>
<script>
  $('#myWizard').wizard();
</script>

@endsection