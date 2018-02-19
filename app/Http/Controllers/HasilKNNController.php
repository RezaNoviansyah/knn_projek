<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Phpml\Classification\KNearestNeighbors;
use Phpml\Math\Distance\Euclidean;
use Phpml\Preprocessing\Normalizer;
use Phpml\Metric\ClassificationReport;


class HasilKNNController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Data hasil
        $data = DB::table('hasil_knn')->join('data_uji', 'hasil_knn.id_uji', '=', 'data_uji.id_uji')->select('hasil_knn.*', 'data_uji.suhu_uji', 'data_uji.kelembapan_uji', 'data_uji.hujan_uji', 'data_uji.angin_uji')->get();

        return view('hasil_knn', ['data_hasil'=>$data]);
    }

    /**
     * Display a math KNN
     *
     * @return \Illuminate\Http\Response
     */
    public function start()
    {
        //$data=Input::all();
        $id_uji = Input::get('id_uji');
        //var_dump($data);
        $k=Input::get('nilai_k');

        if ($k < 3) {
           return redirect('data_uji')->with('warning', 'Nilai K kurang dari 3');
        }

        $data_uji = DB::table('data_uji')->select(DB::raw('*'))->whereRAW("id_uji='$id_uji'")->get();
        $data_latih = DB::table('data_latih')->get();
        $jumlah_data_latih = DB::table('data_latih')->count();

        $ada_hasil = DB::table('hasil_knn')->where([['id_uji','=',$id_uji],['nilai_k','=',$k]])->count();

        $ada_hitung = DB::table('hitung_log')->where('id_uji','=',$id_uji)->count();

        //echo $jumlah_data_latih;

        foreach ($data_uji as $value_uji) {
            //var_dump($value_uji);
            $suhu_uji = $value_uji->suhu_uji;
            $kelembapan_uji = $value_uji->kelembapan_uji;
            $hujan_uji = $value_uji->hujan_uji;
            $angin_uji = $value_uji->angin_uji;
            //$array = get_object_vars($value_uji);
            //echo $array;
            //echo json_encode($value_uji);
            //echo "[".$value_uji[0]."]";
        }

        $id_latih=[];
        $suhu_latih=[];
        $kelembapan_latih=[];
        $hujan_latih =[];
        $angin_latih=[];
        $fwi_latih=[];
        foreach ($data_latih as $value_latih) {
            array_push($id_latih, $value_latih->id_latih);
            array_push($suhu_latih, $value_latih->suhu_latih);
            array_push($kelembapan_latih, $value_latih->kelembapan_latih);
            array_push($hujan_latih, $value_latih->hujan_latih);
            array_push($angin_latih, $value_latih->angin_latih);
            array_push($fwi_latih, $value_latih->fwi_latih);
        }
        //print_r($id_latih);
        //echo $arr_latih[0];



        // PERHITUNGAN METODE KNN

        $euclidean = new Euclidean();
        $classifier_fwi = new KNearestNeighbors($k, new Euclidean());

        for ($i=0; $i < $jumlah_data_latih ; $i++) {

            
            $array_uji=[[$suhu_uji, $kelembapan_uji, $hujan_uji, $angin_uji]];
            $array_latih=[[$suhu_latih[$i],$kelembapan_latih[$i],$hujan_latih[$i],$angin_latih[$i]]];
        
            // Normalisasi Data Uji
            $normalizer_data_uji = new Normalizer();
            $normalizer_data_uji->fit($array_uji);
            $normalizer_data_uji->transform($array_uji);
            
            // Normalisasi Data Latih
            $normalizer_data_latih = new Normalizer();
            $normalizer_data_latih->fit($array_latih);
            $normalizer_data_latih->transform($array_latih);


            // Hitung Nilai FWI dengan Metode KNN
            // Ambil Nilai data Latih FWI
            $samples_fwi =[[$suhu_latih[$i],$kelembapan_latih[$i],$hujan_latih[$i],$angin_latih[$i]]];
            $labels_fwi =[$fwi_latih[$i]];

            // Normalisasi Label FWI
            $normalizer_fwi_latih = new Normalizer();
            $normalizer_fwi_latih->fit($samples_fwi);
            $normalizer_fwi_latih->transform($samples_fwi);
    
            // Hitung Data FWI
            $classifier_fwi->train($samples_fwi, $labels_fwi);   
            $nilai_fwi = $classifier_fwi->predict($array_uji[0]);

            // Rumus Nilai Jarak Dengan Euclidean
            $a=$array_uji[0];
            $b=$array_latih[0];
            $nilai_euclidean = $euclidean->distance($a, $b);
            //print_r($b);

            if ($ada_hitung==0) {
               
            // Simpan Ke DATABASE tabel hitung_log
            DB::table('hitung_log')->insert([   
                'id_latih'                  => $id_latih[$i],
                'id_uji'                    => $id_uji,
                'normal_suhu_uji'           => $array_uji[0][0],
                'normal_kelembapan_uji'     => $array_uji[0][1],
                'normal_hujan_uji'          => $array_uji[0][2],
                'normal_angin_uji'          => $array_uji[0][3],
                'normal_suhu_latih'         => $array_latih[0][0],
                'normal_kelembapan_latih'   => $array_latih[0][1],
                'normal_hujan_latih'        => $array_latih[0][2],
                'normal_angin_latih'        => $array_latih[0][3],
                'jarak'                     => $nilai_euclidean,
                'nilai_k'                   => $k,
                'label_fwi'                 => $fwi_latih[$i]
                ]);      
 
            }
        }
       
        if ($ada_hasil==0) {
        //Simpan Ke DATABASE tabel hasil_knn
            DB::table('hasil_knn')->insert([
                'id_uji'        => $id_uji,
                'nilai_k'       => $k,
                'label_fwi'     => $nilai_fwi
                ]);
        }else{
            return redirect('data_uji')->with('warning', 'Data telah diuji dengan nilai K yang sama silahkan ke Menu Hasil KNN');
        }

        $id_hasil = DB::getPdo('hasil_knn')->lastInsertId();

        return redirect('hitung_knn/'.$id_uji.'/'.$id_hasil);

        if ($id_hasil==0) {
            return redirect('data_uji')->with('warning', 'Data telah diuji');
        }
        
    }

    public function uji_semua(){
        $k=Input::get('nilai_k');

        if ($k < 3) {
           return redirect('data_uji')->with('warning', 'Nilai K kurang dari 3');
        }
        $data_uji = DB::table('data_uji')->get();
        $data_latih = DB::table('data_latih')->get();
        $jumlah_data_uji = DB::table('data_uji')->count();
        $jumlah_data_latih = DB::table('data_latih')->count();

        $ada_hasil = DB::table('hasil_knn')->where('nilai_k','=',$k)->count();
        $ada_hitung = DB::table('hitung_log')->where('nilai_k','=',$k)->count();

        $id_uji=[];
        $suhu_uji=[];
        $kelembapan_uji=[];
        $hujan_uji =[];
        $angin_uji=[];
        $fwi_uji=[];
        foreach ($data_uji as $value_uji) {
            array_push($id_uji, $value_uji->id_uji);
            array_push($suhu_uji, $value_uji->suhu_uji);
            array_push($kelembapan_uji, $value_uji->kelembapan_uji);
            array_push($hujan_uji, $value_uji->hujan_uji);
            array_push($angin_uji, $value_uji->angin_uji);
        }

        $id_latih=[];
        $suhu_latih=[];
        $kelembapan_latih=[];
        $hujan_latih =[];
        $angin_latih=[];
        $fwi_latih=[];
        foreach ($data_latih as $value_latih) {
            array_push($id_latih, $value_latih->id_latih);
            array_push($suhu_latih, $value_latih->suhu_latih);
            array_push($kelembapan_latih, $value_latih->kelembapan_latih);
            array_push($hujan_latih, $value_latih->hujan_latih);
            array_push($angin_latih, $value_latih->angin_latih);
            array_push($fwi_latih, $value_latih->fwi_latih);
        }

        $euclidean = new Euclidean();
        $classifier_fwi = new KNearestNeighbors($k, new Euclidean());

        for ($i=0; $i < $jumlah_data_latih; $i++) { 
            $listInsert = [];
            for ($j=0; $j < $jumlah_data_uji ; $j++) { 
                $array_uji=[[$suhu_uji[$j], $kelembapan_uji[$j], $hujan_uji[$j], $angin_uji[$j]]];
                $array_latih=[[$suhu_latih[$i],$kelembapan_latih[$i],$hujan_latih[$i],$angin_latih[$i]]];

                // Normalisasi Data Uji
                $normalizer_data_uji = new Normalizer();
                $normalizer_data_uji->fit($array_uji);
                $normalizer_data_uji->transform($array_uji);
                
                // Normalisasi Data Latih
                $normalizer_data_latih = new Normalizer();
                $normalizer_data_latih->fit($array_latih);
                $normalizer_data_latih->transform($array_latih);

                // Hitung Nilai FWI dengan Metode KNN
                // Ambil Nilai data Latih FWI
                $samples_fwi =[[$suhu_latih[$i],$kelembapan_latih[$i],$hujan_latih[$i],$angin_latih[$i]]];
                $labels_fwi =[$fwi_latih[$i]];

                // Normalisasi Label FWI
                $normalizer_fwi_latih = new Normalizer();
                $normalizer_fwi_latih->fit($samples_fwi);
                $normalizer_fwi_latih->transform($samples_fwi);
        
                // Hitung Data FWI
                $classifier_fwi->train($samples_fwi, $labels_fwi);   
                $nilai_fwi = $classifier_fwi->predict($array_uji[0]);

                // Rumus Nilai Jarak Dengan Euclidean
                $a=$array_uji[0];
                $b=$array_latih[0];
                $nilai_euclidean = $euclidean->distance($a, $b);
                
                if ($ada_hitung==0) {
               
                array_push($listInsert,[   
                    'id_latih'                  => $id_latih[$i],
                    'id_uji'                    => $id_uji[$j],
                    'normal_suhu_uji'           => $array_uji[0][0],
                    'normal_kelembapan_uji'     => $array_uji[0][1],
                    'normal_hujan_uji'          => $array_uji[0][2],
                    'normal_angin_uji'          => $array_uji[0][3],
                    'normal_suhu_latih'         => $array_latih[0][0],
                    'normal_kelembapan_latih'   => $array_latih[0][1],
                    'normal_hujan_latih'        => $array_latih[0][2],
                    'normal_angin_latih'        => $array_latih[0][3],
                    'jarak'                     => $nilai_euclidean,
                    'nilai_k'                   => $k,
                    'label_fwi'                 => $fwi_latih[$i]
                    ]);      
     
                }

                //echo $nilai_euclidean."<br>";
            }

            // Simpan Ke DATABASE tabel hitung_log
+            DB::table('hitung_log')->insert($listInsert); 

        }     

        //echo $k;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function hitung($id_uji,$id_hasil)
    {
        //echo $id;
        $data_uji = DB::table('data_uji')->where('id_uji','=',$id_uji)->get();
        $nilai_k = DB::table('hasil_knn')->select('nilai_k')->where('id_uji','=',$id_uji)->where('id_hasil','=',$id_hasil)->get();
        $hitung = DB::table('hitung_log')->where('id_uji','=',$id_uji)->limit('10')->orderBy('jarak', 'ASC')->get();
        $nilai_label = DB::table('hasil_knn')->select('label_fwi')->where('id_uji','=',$id_uji)->where('id_hasil','=',$id_hasil)->get();
        
        foreach ($data_uji as $value_uji) {
            $suhu_uji = $value_uji->suhu_uji;
            $kelembapan_uji = $value_uji->kelembapan_uji;
            $hujan_uji = $value_uji->hujan_uji;
            $angin_uji = $value_uji->angin_uji;   
        }

        $array_uji=[[$suhu_uji, $kelembapan_uji, $hujan_uji, $angin_uji]];
        $normalizer_data_uji = new Normalizer();
        $normalizer_data_uji->fit($array_uji);
        $normalizer_data_uji->transform($array_uji);

        foreach ($nilai_k as $nilai) {
            $k = $nilai->nilai_k;
        }

        foreach ($nilai_label as $value_label) {
            $label_fwi  = $value_label->label_fwi;
        }
        
        if ($label_fwi=="EKSTRIM") {
            $bg_fwi = "bg-red";
        }elseif($label_fwi=="TINGGI"){
            $bg_fwi = "bg-yellow";
        }elseif($label_fwi=="SEDANG"){
            $bg_fwi = "bg-green";
        }elseif($label_fwi=="RENDAH"){
            $bg_fwi = "bg-aqua";
        }


        //echo $k;
        return view('hitung',['data_uji'=>$data_uji, 'normal_uji'=>$array_uji, 'k'=>$k, 'hitung'=>$hitung, 'label_fwi'=>$label_fwi, 'bg_fwi'=>$bg_fwi]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function kalkulasi()
    {
        //
        $k = Input::get('nilai_k');

        $ada_k = DB::table('hasil_knn')->where('nilai_k','=',$k)->count();
    
        $fwi_aktual = DB::table('aktual_uji')->select('fwi_aktual')->get();
        $fwi_uji = DB::table('hasil_knn')->select('label_fwi')->where('nilai_k','=',$k)->get();

        if ($ada_k==0) {
            return redirect('hasil_knn')->with('warning', 'Nilai K Belum Diujikan/Tidak ada data uji dengan nilai K ini');
        }

        $aktual_fwi=[];
        foreach ($fwi_aktual as $value_fwi) {
            array_push($aktual_fwi, $value_fwi->fwi_aktual);
        
        }
        $uji_fwi =[];
        foreach ($fwi_uji as $value_fwi1) {
            array_push($uji_fwi, $value_fwi1->label_fwi);
        
        }

        
        // echo implode(", ", $aktual_ffmc);
        
            $actualLabels = $aktual_fwi;
            $predictedLabels = $uji_fwi;
            $report = new ClassificationReport($actualLabels, $predictedLabels);

            print_r($report->getAverage());



        //return view('kalkulasi',['k'=>$k]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
