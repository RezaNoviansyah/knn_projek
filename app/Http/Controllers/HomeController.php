<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    

    public function index()
    {
        $jumlah_data_latih = DB::table('data_latih')->count();
        $jumlah_data_uji = DB::table('data_uji')->count();

       
        // FWI
        $jumlah_fwi_rendah = DB::table('data_latih')->where('fwi_latih','=','RENDAH')->count();
        $jumlah_fwi_sedang = DB::table('data_latih')->where('fwi_latih','=','SEDANG')->count();
        $jumlah_fwi_tinggi = DB::table('data_latih')->where('fwi_latih','=','TINGGI')->count();
        $jumlah_fwi_ekstrim = DB::table('data_latih')->where('fwi_latih','=','EKSTRIM')->count();
       

       

        return view('home',['jumlah_data_latih' => $jumlah_data_latih,'jumlah_data_uji' => $jumlah_data_uji, 'jumlah_fwi_rendah' => $jumlah_fwi_rendah,'jumlah_fwi_sedang' => $jumlah_fwi_sedang,'jumlah_fwi_tinggi' => $jumlah_fwi_tinggi,'jumlah_fwi_ekstrim' => $jumlah_fwi_ekstrim,]);
    }
}
