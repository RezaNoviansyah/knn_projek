<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Bagian Tanpa Login (USER)
Route::get('/', 'UserController@user_index');
Route::get('about', 'UserController@about');

Route::get('home', 'HomeController@index');

Route::get('data_uji', 'DataUjiController@index');
Route::post('data_uji/simpan_data', 'DataUjiController@create');
Route::get('data_uji/show/{id}', 'DataUjiController@show');
Route::post('data_uji/update', 'DataUjiController@update');
Route::post('data_uji/delete', 'DataUjiController@delete');

// BAGIAN HITUNG KNN
Route::get('hasil_knn', 'HasilKNNController@index');
Route::post('uji_semua', 'HasilKNNController@uji_semua');
Route::post('kalkulasi', 'HasilKNNController@kalkulasi');
Route::post('hasil_knn/mulai', 'HasilKNNController@start');
Route::get('hitung_knn/{id_uji}/{id_hasil}', 'HasilKNNController@hitung');


// Bagian Dengan Login (ADMIN)
Auth::routes();

Route::get('data_latih', 'DataLatihController@index');
Route::post('data_latih/simpan_data', 'DataLatihController@create');
Route::get('data_latih/show/{id_uji}', 'DataLatihController@show');
Route::post('data_latih/update', 'DataLatihController@update');
Route::post('data_latih/delete', 'DataLatihController@delete');


