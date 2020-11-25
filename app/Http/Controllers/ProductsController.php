<?php

namespace App\Http\Controllers;

use App\Product;
use App\Cart;
use App\Kategori;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index($kategori = '')
    {
        $data = [];
        $data = Cart::getCart();
        $data['carts'] = Cart::cart();
        if($kategori){
            $data['barang'] = Product::where('kategori', $kategori)->get();
        }else{
            $data['barang'] = Product::all();
        }
        $data['menu'] = Cart::menu();
        $data['ongkir'] = Cart::_ongkir();
        $data['active'] = $kategori;
        // dd($data);
        return view('belanja.index', $data);
    }

    public function search(Request $cari)
    {
        $data = [];
        $data['barang'] = Product::where('nama', 'like', "%$cari->cari%")->get();
        $data['menu'] = Cart::menu();
        $data['carts'] = Cart::cart();
        $data['ongkir'] = Cart::_ongkir();
        $data['active'] = '';
        return view('belanja.index', $data);
    }


    public function show($detail)
    {
        $data = Product::getStok($detail);
        $data = Cart::getCart($data);
        $data['data'] = Product::where(['products.kode_barang' => $detail])->first();
        if($data['data']){
            $data['menu'] = Cart::menu();
            $data['carts'] = Cart::cart();
            $data['ongkir'] = Cart::_ongkir();
            $data['active'] = $data['data']->kategori;
            $data['nama_kategori'] = Kategori::where('slug', $data['active'])->first()->nama_kategori;
            return view('belanja.detail', $data);
        }else{
            return abort(404);
        }
    }

    public function keranjang(Request $data)
    {
        $produk = Product::where('kode_barang', $data->kode_barang)->first();
        $jumlah = Product::convertStok($data);
        $jumlah = $jumlah['hasil'];
        if($jumlah == 0){
            return back(302)->with('pesan', [
                'pesan' => 'Barang gagal dimasukan ke keranjang, jumlah tidak boleh 0',
                'type' => 'danger'
            ]);
        }else{
            if($jumlah <= $produk->stok){
                session(['item_'.$data->kode_barang => $jumlah]);
                return back(302)->with('pesan', [
                    'pesan' => 'Barang telah dimasukan ke keranjang',
                    'type' => 'success'
                ]);
            }else{
                return back(302)->with('pesan', [
                    'pesan' => 'Barang gagal dimasukan ke keranjang, jumlah beli melebihi stok!',
                    'type' => 'danger'
                ]);
            }
        }
    }

}
