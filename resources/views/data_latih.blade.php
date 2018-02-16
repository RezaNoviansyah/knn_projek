@extends('adminlte::page')

@section('title', 'Data Latih KNN Projek')

@section('content_header')
    <li class="" style="list-style-type: none;">
      <h1>
        Data Latih
        <small>Data Penelitian</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{URL::to('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Data Latih</li>
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
              <h3 class="box-title">Data Penelitian Pada Manggala Agni</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                Tambah Data Latih
              </button>
              <br><br>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Tanggal Training</th>
                  <th>Suhu</th>
                  <th>Kelembapan</th>
                  <th>Curah Hujan</th>
                  <th>Kec. Angin</th>
                  <th>FWI</th>
                  <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data as $baris)
                <tr>
                  <td>{{ $baris->tgl_latih }}</td>
                  <td>{{ $baris->suhu_latih }}</td>
                  <td>{{ $baris->kelembapan_latih }}</td>
                  <td>{{ $baris->hujan_latih }}</td>
                  <td>{{ $baris->angin_latih }}</td>
                  <td>{{ $baris->fwi_latih }}</td>
                  <td align="center">
                    <button type="button" tag_id="{{ $baris->id_latih }}" class="btn btn-primary edit_data" data-toggle="modal" data-target="#modal-update">
                      <i class="fa fa-pencil"></i>
                    </button>
                    &nbsp;&nbsp;&nbsp;
                    <button type="button" tag_id="{{ $baris->id_latih }}" class="btn btn-primary hapus_data" data-toggle="modal" data-target="#modal-delete">
                      <i class="fa fa-trash"></i>
                    </button>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Tanggal Training</th>
                  <th>Suhu</th>
                  <th>Kelembapan</th>
                  <th>Curah Hujan</th>
                  <th>Kec. Angin</th>
                  <th>FWI</th>
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
      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('data_latih/simpan_data')}}">
            {!! csrf_field() !!}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Tambah Data Latih</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Tanggal Latih</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="tgl_latih" value="<?php echo date('Y-m-d'); ?>" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Suhu</label>
                  <input type="text" class="form-control" name="suhu_latih" id="" placeholder="Masukkan Nilai Suhu">
                </div>
                <div class="form-group">
                  <label for="">Kelembapan</label>
                  <input type="text" class="form-control" name="kelembapan_latih" id="" placeholder="Masukkan Nilai Kelembapan">
                </div>
                <div class="form-group">
                  <label for="">Curah Hujan</label>
                  <input type="text" class="form-control" name="curah_hujan_latih" id="" placeholder="Masukkan Nilai Curah Hujan">
                </div>
                <div class="form-group">
                  <label for="">Kecepatan Angin</label>
                  <input type="text" class="form-control" name="kecepatan_angin_latih" id="" placeholder="Masukkan Nilai Kecepatan Angin">
                </div>
                <div class="form-group">
                  <label for="">FWI</label>
                  <select name="fwi_latih" id="" class="form-control">
                    <option value="RENDAH">RENDAH</option>
                    <option value="SEDANG">SEDANG</option>
                    <option value="TINGGI">TINGGI</option>
                    <option value="EKSTRIM">EKSTRIM</option>
                  </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modal-update">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('data_latih/update')}}">
            {!! csrf_field() !!}
            <input type="hidden" name="id_latih" id="edit_id_latih">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Data Latih</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Tanggal Latih</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="tgl_latih" id="edit_tgl_latih">
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Suhu</label>
                  <input type="text" class="form-control" name="suhu_latih" id="edit_suhu_latih" placeholder="Masukkan Nilai Suhu">
                </div>
                <div class="form-group">
                  <label for="">Kelembapan</label>
                  <input type="text" class="form-control" name="kelembapan_latih" id="edit_kelembapan_latih" placeholder="Masukkan Nilai Kelembapan">
                </div>
                <div class="form-group">
                  <label for="">Curah Hujan</label>
                  <input type="text" class="form-control" name="curah_hujan_latih" id="edit_curah_hujan_latih" placeholder="Masukkan Nilai Curah Hujan">
                </div>
                <div class="form-group">
                  <label for="">Kecepatan Angin</label>
                  <input type="text" class="form-control" name="kecepatan_angin_latih" id="edit_kecepatan_angin_latih" placeholder="Masukkan Nilai Kecepatan Angin">
                </div>
                <div class="form-group">
                  <label for="">FWI</label>
                  <select name="fw_latih" id="edit_fwi_latih" class="form-control">
                    <option value="RENDAH">RENDAH</option>
                    <option value="SEDANG">SEDANG</option>
                    <option value="TINGGI">TINGGI</option>
                    <option value="EKSTRIM">EKSTRIM</option>
                  </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Selesai</button>
            </div>
            </form>
          </div>
        </div>
      </div>
      <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <form role="form" method="POST" action="{{URL('data_latih/delete')}}">
            {!! csrf_field() !!}
            <input type="hidden" name="id_latih" id="hapus_id_latih">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Hapus Data Latih</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                  <label>Tanggal Latih</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" name="hapus_tgl_latih" id="hapus_tgl_latih" readonly disabled="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Suhu</label>
                  <input type="text" class="form-control" name="suhu_latih" id="hapus_suhu_latih" placeholder="Masukkan Nilai Suhu" readonly disabled="">
                </div>
                <div class="form-group">
                  <label for="">Kelembapan</label>
                  <input type="text" class="form-control" name="kelembapan_latih" id="hapus_kelembapan_latih" placeholder="Masukkan Nilai Kelembapan" readonly disabled="">
                </div>
                <div class="form-group">
                  <label for="">Curah Hujan</label>
                  <input type="text" class="form-control" name="curah_hujan_latih" id="hapus_curah_hujan_latih" placeholder="Masukkan Nilai Curah Hujan" readonly disabled="">
                </div>
                <div class="form-group">
                  <label for="">Kecepatan Angin</label>
                  <input type="text" class="form-control" name="kecepatan_angin_latih" id="hapus_kecepatan_angin_latih" placeholder="Masukkan Nilai Kecepatan Angin" readonly disabled="">
                </div>
                <div class="form-group">
                  <label for="">FWI</label>
                  <select name="fwi_latih" id="hapus_fwi_latih" class="form-control" disabled="">
                    <option value="RENDAH">RENDAH</option>
                    <option value="SEDANG">SEDANG</option>
                    <option value="TINGGI">TINGGI</option>
                    <option value="EKSTRIM">EKSTRIM</option>
                  </select>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
            </form>
          </div>
        </div>
      </div>
@stop
@section('js')
<script>
  setTimeout(fade_out, 3000);

  function fade_out() {
    $(".data_notif").fadeOut().empty();
  }
</script>
<script>
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
  $(".edit_data").click(function(event) {
    var id_latih = $(this).attr('tag_id');
    var loc = window.location;
    var url = loc + "/show/" + id_latih;

    $.getJSON(url, function(data) {
        $('#edit_id_latih').val(id_latih);
        $('#edit_tgl_latih').val(data[0].tgl_latih);
        $('#edit_suhu_latih').val(data[0].suhu_latih);
        $('#edit_kelembapan_latih').val(data[0].kelembapan_latih);
        $('#edit_curah_hujan_latih').val(data[0].hujan_latih);
        $('#edit_kecepatan_angin_latih').val(data[0].angin_latih);
        $('#edit_fwi_latih').val(data[0].fwi_latih);
        
        });
    
  });
</script>
<script>
  $(".hapus_data").click(function(event) {
    var id_latih = $(this).attr('tag_id');
    var loc = window.location;
    var url = loc + "/show/" + id_latih;

    $.getJSON(url, function(data) {
        $('#hapus_id_latih').val(id_latih);
        $('#hapus_tgl_latih').val(data[0].tgl_latih);
        $('#hapus_suhu_latih').val(data[0].suhu_latih);
        $('#hapus_kelembapan_latih').val(data[0].kelembapan_latih);
        $('#hapus_curah_hujan_latih').val(data[0].hujan_latih);
        $('#hapus_kecepatan_angin_latih').val(data[0].angin_latih);
        $('#hapus_fwi_latih').val(data[0].fwi_latih);
        
        });
    
  });
</script>
@endsection