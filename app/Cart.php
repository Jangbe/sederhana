<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart extends Model
{
    protected $guarded = ['created_at', 'updated_at'];

    public static function cart()
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

    public static function getCart($rincian = []){
        if(count($rincian) > 1){
            $data = $rincian;
        }
        $carts = Cart::cart();
        $data['total_harga'] = 0;
        $data['jumlah_item'] = 0;
        $data['jumlah_berat'] = 0;
        $data['detail'] = [];
        if($carts){
            $index = 0;
            foreach($carts as $cart){
                $data['detail'][$index]['kode'] = $cart['data']->kode_barang;
                $data['detail'][$index]['nama'] = $cart['data']->nama;
                $data['detail'][$index]['jumlah'] = $cart['jumlah'];
                $data['detail'][$index]['harga'] = $cart['data']->harga;
                $data['detail'][$index]['total'] = number_format($cart['jumlah'] * $cart['data']->harga);
                $data['detail'][$index]['berat'] = $cart['jumlah'] * $cart['data']->berat;
                $data['total_harga'] += $cart['jumlah'] * $cart['data']->harga;
                $data['detail'][$index]['harga'] = number_format($cart['data']->harga);
                $data['jumlah_item'] += $cart['jumlah'];
                $data['jumlah_berat'] += $cart['jumlah'] * $cart['data']->berat;
                $index++;
            }
        }
        return $data;
    }

    public static function menu()
    {
        $data = Kategori::getKategori();
        $result = [];
        $result['link'][] = '';
        $result['menu'][] = 'Semua';
        foreach($data as $menu){
            $result['link'][] = $menu->slug;
            $result['menu'][] = $menu->nama_kategori;
        }
        // dd($result);
        return $result;
    }

    public static function _ongkir()
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

    public static function ongkir(Request $data)
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
}
