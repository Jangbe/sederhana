<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/belanja', 'ProductsController@index');
Route::get('/belanja/detail/{detail}', 'ProductsController@show');
Route::get('/belanja/{kategori}', 'ProductsController@index');
Route::post('/belanja/keranjang', 'CartsController@keranjang');
Route::post('/belanja/cari', 'ProductsController@search');
Route::get('/keranjang', 'ProductsController@keranjang');
Route::post('/keranjang/add', 'CartsController@store');
Route::get('/keranjang/detail/{id}', 'CartsController@detail');
Route::get('/keranjang/hapus/{id}', 'CartsController@destroy');
Route::post('/ongkir', 'ProductsController@ongkir');
Route::group(['middleware' => 'role:admin'], function(){
    Route::get('/admin', 'AdminsController@index');
    Route::get('/admin/keranjang/{id}', 'AdminsController@detail');
    Route::get('/produk/add', 'AdminsController@create');
    Route::get('/produk/edit', 'AdminsController@edit');
    Route::get('/produk/edit/{id}', 'AdminsController@edit1');
    Route::get('/produk/delete/{id}', 'AdminsController@destroy');
    Route::post('/produk/add', 'AdminsController@add_produk');
    Route::post('/produk/edit/update', 'AdminsController@update');
    Route::post('/produk/cari', 'AdminsController@search');
});
Route::get('/register', 'AuthsController@daftar');
Route::get('/login', 'AuthsController@masuk');
Route::get('/logout', 'AuthsController@logout');
Route::post('/register', 'AuthsController@register');
Route::post('/login', 'AuthsController@login');
