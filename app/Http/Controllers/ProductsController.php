<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Ongkir;

class ProductsController extends Controller
{
    public function _cart()
    {
        $data = [];
        foreach(session()->all() as $key => $value){
            if(substr($key, 0, 5) == 'item_'){
                $item = substr($key, 5, (strlen($key) -5));
                $data[] = [
                    'data' =>Product::where('kode_barang', $item)->first(),
                    'jumlah' => $value
                ];
            }
        }
        return $data;
    }

    public function index($kategori = '')
    {
        $data = [];
        if($kategori){
            $data['barang'] = Product::where('kategori', $kategori)->get();
        }else{
            $data['barang'] = Product::all();
        }
        $data['carts'] = $this->_cart();
        $data['menu'] = $this->_menu();
        $data['ongkir'] = $this->_ongkir();
        $data['active'] = $kategori;
        return view('belanja.index', $data);
    }

    public function search(Request $cari)
    {
        $data = [];
        $data['barang'] = Product::where('nama', 'like', "%$cari->cari%")->get();
        $data['menu'] = $this->_menu();
        $data['carts'] = $this->_cart();
        $data['ongkir'] = $this->_ongkir();
        $data['active'] = '';
        return view('belanja.index', $data);
    }

    
    public function show($detail)
    {
        $data = [];
        $data['data'] = Product::where('kode_barang', $detail)->get();
        $data['menu'] = $this->_menu();
        $data['carts'] = $this->_cart();
        $data['ongkir'] = $this->_ongkir();
        $data['active'] = $data['data'][0]->kategori;
        return view('belanja.detail', $data);
    }

    public function _menu()
    {
        return [
            'link' => ['','Roko', 'Sabun', 'Makanan'],
            'menu' => ['Semua', 'Roko', 'Sabun', 'Makanan']
        ];
    }

    public function _ongkir()
    {
        $kec = [];
        $ongkir = Ongkir::orderby('kec', 'asc')->get();
        $jml = count($ongkir);
        for($i = 0; $i < $jml; $i++){
            if($i != $jml-1){
                if($ongkir[$i]->kec != $ongkir[$i+1]->kec){
                    $kec[] = $ongkir[$i]->kec;
                }
            }
        }
        return $kec;
    }

    public function ongkir(Request $data)
    {
        $kec = $data->kec;
        $desa = $data->desa;
        if($desa == ''){
            $ongkir = Ongkir::where('kec', $kec)->orderby('desa', 'asc')->get();
        }else{
            $ongkir = Ongkir::where(['kec' => $kec, 'desa' => $desa])->first();
        }
        return $ongkir;
    }

    public function keranjang()
    {
        $data = [];
        $data['barang'] = Product::all();
        $data['carts'] = $this->_cart();
        $data['menu'] = $this->_menu();
        $data['ongkir'] = $this->_ongkir();
        $data['active'] = '';
        foreach(session()->all() as $key => $value){
            if(substr($key, 0, 5) == 'item_'){
                $data['tersedia'] = true;
            }else{
                $data['tersedia'] = false;
            }
        }
        return view('belanja.keranjang', $data);
    }

}
