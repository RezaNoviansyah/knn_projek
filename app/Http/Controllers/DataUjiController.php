<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;

class DataUjiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('data_uji')->get();
        return view('data_uji', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        DB::table('data_uji')->insert(
            [   'tgl_uji' => Input::get('tgl_uji'),
                'suhu_uji' => Input::get('suhu_uji'),
                'kelembapan_uji' => Input::get('kelembapan_uji'),
                'hujan_uji' => Input::get('curah_hujan_uji'),
                'angin_uji' => Input::get('kecepatan_angin_uji')    ]
        
            );

            // return response ()->json ( $data );

        return redirect('data_uji')->with('status', 'Data Telah Ditambahkan!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = DB::table('data_uji')->select(DB::raw('*'))->whereRAW("id_uji='$id'")->get();
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
        $id = Input::get('id_uji');
        //echo $id;
        var_dump($data);
        DB::table('data_uji')
            ->where('id_uji', $id)
            ->update(['tgl_uji' => Input::get('tgl_uji'),
                'suhu_uji' => Input::get('suhu_uji'),
                'kelembapan_uji' => Input::get('kelembapan_uji'),
                'hujan_uji' => Input::get('curah_hujan_uji'),
                'angin_uji' => Input::get('kecepatan_angin_uji')]);

        return redirect('data_uji')->with('status', 'Data Telah Berhasil Diupdate!!');
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
        $id = Input::get('id_uji');
        //echo $id;
        var_dump($data);
        DB::table('data_uji')->where('id_uji', '=', $id)->delete();

        return redirect('data_uji')->with('warning', 'Data Telah Berhasil Dihapus!!');
    }
}
