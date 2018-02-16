@extends('adminlte::page')

@section('title', 'Data Training KNN Projek')

@section('css')
   <link rel="stylesheet" href="{{ asset('vendor/adminlte/bootstrap/css/bootstrap-datepicker.min.css')}}">
   <style>
     .col-centered{
      float: none;
      margin: 0 auto;
     }
   </style>
@stop
@section('content_header')
    <li class="" style="list-style-type: none;">
      <h1>
       HASIL KLASIFIKASI DATA UJI
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
              <div class="col-lg-4 col-xs-6 col-centered">
                <!-- small box -->
                <div class="small-box {{$bg_fwi}}">
                  <div class="inner">
                    <h3>{{$label_fwi}}</h3>

                    <p>Nilai FWI</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-gear"></i>
                  </div>
                  <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                  </a>
                </div>
              </div>
              <br>
              <h4>Proses Perhitungan :</h4>
              <h5>Masukkan Nilai Data Uji ke Matrik</h5>
              @foreach($data_uji as $uji)
              [ {{$uji->suhu_uji}}, {{$uji->kelembapan_uji}}, {{$uji->hujan_uji}}, {{$uji->angin_uji}} ]
              @endforeach
              <h5>Gunakan rumus Vektor Norm untuk Normalisasi Data (Prepocessing)</h5>
              <img src="{{ asset('image/vektor1.gif')}}" alt="">&nbsp;<img src="{{ asset('image/vektor.gif')}}" alt="">&nbsp;<img src="{{ asset('image/vektor2.gif')}}" alt="">
              <h5>Hasil Matriks yang didapat setelah normalisasi</h5>
              @foreach($normal_uji as $uji2)
                <?php echo "[ ".implode(", ",$uji2)." ]"; ?>
              @endforeach
              <br>
              <h5>Sama halnya pada Data latih juga akan dilakukan normalisasi data</h5>
              <h5>Setelah didapatkan hasil normalisasi data maka akan dihitung dengan menggunakan rumus <i>Euclidean</i></h5>
              <img src="{{ asset('image/euclidean.jpg')}}" alt="">
              <h5>Dari rumus <i>Euclidean</i> akan didapatkan jarak data uji terhadap tiap data latih</h5>
              <h5>Jarak yang didapat akan diurutkan berdasarkan nilai paling kecil</h5>
              <h5>dari nilai K akan dicari label terbanyak berdasarkan nilai jarak terkecil</h5>
              <h5>Dalam perhitungan ini nilai k = {{$k}}</h5>
              <h5>Contoh 10 data Latih dengan nilai jarak data uji dan latih yang telah diurutkan dan nilai data latih dan data uji yang sudah dinormalisasi</h5>
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Suhu Uji</th>
                  <th>Kelembapan Uji</th>
                  <th>Curah Hujan Uji</th>
                  <th>Kec. Angin Uji</th>
                  <th>Suhu Latih</th>
                  <th>Kelembapan Latih</th>
                  <th>Curah Hujan Latih</th>
                  <th>Kec. Angin Latih</th>
                  <th>Jarak</th>
                  <th>Label FWI</th>
                </tr>
                </thead>
                <tbody>
                @foreach($hitung as $nilai_hitung)
                <tr>
                  <td>{{$nilai_hitung->normal_suhu_uji}}</td>
                  <td>{{$nilai_hitung->normal_kelembapan_uji}}</td>
                  <td>{{$nilai_hitung->normal_hujan_uji}}</td>
                  <td>{{$nilai_hitung->normal_angin_uji}}</td>
                  <td>{{$nilai_hitung->normal_suhu_latih}}</td>
                  <td>{{$nilai_hitung->normal_kelembapan_latih}}</td>
                  <td>{{$nilai_hitung->normal_hujan_latih}}</td>
                  <td>{{$nilai_hitung->normal_angin_latih}}</td>
                  <td>{{$nilai_hitung->jarak}}</td>
                  <td>{{$nilai_hitung->label_fwi}}</td>
                </tr>
                @endforeach
                </tbody>
              </table>
              <br>
              <a href="{{url('hasil_knn')}}"><button type="button" class="btn btn-success">
                <i class="fa fa-fw fa-arrow-left"></i> Kembali
              </button></a>
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