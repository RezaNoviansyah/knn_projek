<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class DataLatihController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = DB::table('data_latih')->get();
        return view('data_latih', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Input::all();
        // var_dump($data);
        DB::table('data_latih')->insert(
            [   'tgl_latih' => Input::get('tgl_latih'),
                'suhu_latih' => Input::get('suhu_latih'),
                'kelembapan_latih' => Input::get('kelembapan_latih'),
                'hujan_latih' => Input::get('curah_hujan_latih'),
                'angin_latih' => Input::get('kecepatan_angin_latih'),
                'fwi_latih' => Input::get('fwi_latih')   ]
        
            );

            //return response ()->json ( $data );

        return redirect('data_latih')->with('status', 'Data Telah Ditambahkan!');
    }

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
    public function show($id)
    {
        $data = DB::table('data_latih')->select(DB::raw('*'))->whereRAW("id_latih='$id'")->get();
        return response ()->json ($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $data = Input::all();
        $id = Input::get('id_latih');
        //echo $id;
        var_dump($data);
        DB::table('data_latih')
            ->where('id_latih', $id)
            ->update(['tgl_latih' => Input::get('tgl_latih'),
                'suhu_latih' => Input::get('suhu_latih'),
                'kelembapan_latih' => Input::get('kelembapan_latih'),
                'hujan_latih' => Input::get('curah_hujan_latih'),
                'angin_latih' => Input::get('kecepatan_angin_latih'),
                'fwi_latih' => Input::get('fwi_latih')]);

        return redirect('data_latih')->with('status', 'Data Telah Berhasil Diupdate!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete()
    {
        $data = Input::all();
        $id = Input::get('id_latih');
        //echo $id;
        var_dump($data);
        DB::table('data_latih')->where('id_latih', '=', $id)->delete();

        return redirect('data_latih')->with('warning', 'Data Telah Berhasil Dihapus!!');
    }
}
