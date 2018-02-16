@extends('adminlte::page')

@section('title', 'Data Training KNN Projek')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap-datepicker.min.css')}}">
@stop
@section('content_header')
    <li class="" style="list-style-type: none;">
      <h1>
        Data Uji
        <small>Data Percobaan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Uji</li>
      </ol>
    </li>
@stop

@section('content')
    @if (session('status'))
    <div class="alert alert-success data_notif">
        {{ session('status') }}
    </div>
    @endif
    @if (session('warning'))
    <div class="alert alert-danger data_notif">
        {{ session('warning') }}
    </div>
    @endif
    <div class="row">
        <div class="col-xs-12">          
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Uji KNN</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-simpan">
                Tambah Data Uji
              </button>
              @if (Auth::check())
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-uji_semua">
                Uji Semua Data
              </button></a>
              @endif
              <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal Uji</th>
                  <th>Suhu</th>
                  <th>Kelembapan</th>
                  <th>Curah Hujan</th>
                  <th>Kec. Angin</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $baris)
                <tr>
                  <td>{{ $baris->tgl_uji }}</td>
                  <td>{{ $baris->suhu_uji }}</td>
                  <td>{{ $baris->kelembapan_uji }}</td>
                  <td>{{ $baris->hujan_uji }}</td>
                  <td>{{ $baris->angin_uji }}</td>
                  <td align="center">
                    <button tag_id="{{ $baris->id_uji }}" type="button" class="btn btn-primary edit_data" data-toggle="modal" data-target="#modal-update">
                      <i class="fa fa-pencil"></i>
                    </button>
                    &nbsp;&nbsp;
                    <button tag_id="{{ $baris->id_uji }}" type="button" class="btn btn-primary hapus_data" data-toggle="modal" data-target="#modal-delete">
                      <i class="fa fa-trash"></i>
                    </button>
                    &nbsp;&nbsp;
                    <button type="button" tag_id="{{ $baris->id_uji }}" class="btn btn-primary mulai_knn" data-toggle="modal" data-target="#modal-default3">
                      Analisa KNN
                    </button>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Tanggal Uji</th>
                  <th>Suhu</th>
                  <th>Kelembapan</th>
                  <th>Curah Hujan</th>
                  <th>Kec. Angin</th>
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

      <div class="modal fade" id="modal-uji_semua">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('uji_semua')}}">
            {!! csrf_field() !!}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Hitung Semua data Berdasarkan Nilai Uji K</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="">Masukkan Nilai K yang akan di Ujikan</label>
                  <input type="text" class="form-control" name="nilai_k" id="" placeholder="Masukkan Nilai K">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Mulai Uji</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-simpan">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('data_uji/simpan_data')}}">
            {!! csrf_field() !!}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Tambah Data Uji</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Tanggal Uji</label>

                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="tgl_uji" value="<?php echo date('Y-m-d'); ?>" readonly>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label for="">Suhu</label>
                  <input type="text" class="form-control" name="suhu_uji" id="suhu_uji" placeholder="Masukkan Nilai Suhu">
                </div>
                <div class="form-group">
                  <label for="">Kelembapan</label>
                  <input type="text" class="form-control" name="kelembapan_uji" id="kelembapan_uji" placeholder="Masukkan Nilai Kelembapan">
                </div>
                <div class="form-group">
                  <label for="">Curah Hujan</label>
                  <input type="text" class="form-control" name="curah_hujan_uji" id="curah_hujan_uji" placeholder="Masukkan Nilai Curah Hujan">
                </div>
                <div class="form-group">
                  <label for="">Kecepatan Angin</label>
                  <input type="text" class="form-control" name="kecepatan_angin_uji" id="kecepatan_angin_uji" placeholder="Masukkan Nilai Kecepatan Angin">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary" id="simpan_button">Simpan</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>
      
      <div class="modal fade" id="modal-update">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('data_uji/update')}}">
            {!! csrf_field() !!}
            <input type="hidden" name="id_uji" id="edit_id_uji">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Data Uji</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Tanggal Uji</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="tgl_uji" id="edit_tgl_uji">
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label for="">Suhu</label>
                  <input type="text" class="form-control" name="suhu_uji" id="edit_suhu_uji" placeholder="Masukkan Nilai Suhu">
                </div>
                <div class="form-group">
                  <label for="">Kelembapan</label>
                  <input type="text" class="form-control" name="kelembapan_uji" id="edit_kelembapan_uji" placeholder="Masukkan Nilai Kelembapan">
                </div>
                <div class="form-group">
                  <label for="">Curah Hujan</label>
                  <input type="text" class="form-control" name="curah_hujan_uji" id="edit_curah_hujan_uji" placeholder="Masukkan Nilai Curah Hujan">
                </div>
                <div class="form-group">
                  <label for="">Kecepatan Angin</label>
                  <input type="text" class="form-control" name="kecepatan_angin_uji" id="edit_kecepatan_angin_uji" placeholder="Masukkan Nilai Kecepatan Angin">
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Selesai</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>
      
      <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('data_uji/delete')}}">
            {!! csrf_field() !!}
            <input type="hidden" name="id_uji" id="hapus_id_uji">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Hapus Data Uji</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Tanggal Uji</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="tgl_uji" id="hapus_tgl_uji" readonly disabled>
                  </div>
                  <!-- /.input group -->
                </div>
                <div class="form-group">
                  <label for="">Suhu</label>
                  <input type="text" class="form-control" name="suhu_uji" id="hapus_suhu_uji" placeholder="Masukkan Nilai Suhu" readonly disabled>
                </div>
                <div class="form-group">
                  <label for="">Kelembapan</label>
                  <input type="text" class="form-control" name="kelembapan_uji" id="hapus_kelembapan_uji" placeholder="Masukkan Nilai Kelembapan" readonly disabled>
                </div>
                <div class="form-group">
                  <label for="">Curah Hujan</label>
                  <input type="text" class="form-control" name="curah_hujan_uji" id="hapus_curah_hujan_uji" placeholder="Masukkan Nilai Curah Hujan" readonly disabled>
                </div>
                <div class="form-group">
                  <label for="">Kecepatan Angin</label>
                  <input type="text" class="form-control" name="kecepatan_angin_uji" id="hapus_kecepatan_angin_uji" placeholder="Masukkan Nilai Kecepatan Angin" readonly disabled>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
          <!-- /.modal-dialog -->
      </div>

      <div class="modal fade" id="modal-default3">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('hasil_knn/mulai')}}">
            {!! csrf_field() !!}
            <input type="hidden" name="id_uji" id="knn_id_uji">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">ANALISA KNN</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label for="">Masukkan Nilai K</label>
                  <input type="text" class="form-control" name="nilai_k" id="" placeholder="Masukkan Nilai K">
                  <small>* Nilai K Minimum = 3</small>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Mulai Analisa</button>
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
  setTimeout(fade_out, 3000);

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
<script>
  $(".edit_data").click(function(event) {
    var id_uji = $(this).attr('tag_id');
    var loc = window.location;
    var url = loc + "/show/" + id_uji;

    $.getJSON(url, function(data) {
        $('#edit_id_uji').val(id_uji);
        $('#edit_tgl_uji').val(data[0].tgl_uji);
        $('#edit_suhu_uji').val(data[0].suhu_uji);
        $('#edit_kelembapan_uji').val(data[0].kelembapan_uji);
        $('#edit_curah_hujan_uji').val(data[0].hujan_uji);
        $('#edit_kecepatan_angin_uji').val(data[0].angin_uji);
        
        });
    
  });
</script>
<script>
  $(".hapus_data").click(function(event) {
    var id_uji = $(this).attr('tag_id');
    var loc = window.location;
    var url = loc + "/show/" + id_uji;

    $.getJSON(url, function(data) {
        $('#hapus_id_uji').val(id_uji);
        $('#hapus_tgl_uji').val(data[0].tgl_uji);
        $('#hapus_suhu_uji').val(data[0].suhu_uji);
        $('#hapus_kelembapan_uji').val(data[0].kelembapan_uji);
        $('#hapus_curah_hujan_uji').val(data[0].hujan_uji);
        $('#hapus_kecepatan_angin_uji').val(data[0].angin_uji);
        
        });
    
  });
</script>
<script>
  $(".mulai_knn").click(function(event) {
    var id_uji = $(this).attr('tag_id');
     $('#knn_id_uji').val(id_uji);
  });
</script>

@endsection