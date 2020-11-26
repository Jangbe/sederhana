<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['created_at', 'updated_at'];
    protected $primaryKey = null;
    public $incrementing = false;

    //View stok barang
    public static function getStok($kode){
        $data['data'] = Product::where('kode_barang', $kode)->first();
        $kategori = Kategori::where('slug', $data['data']->kategori)->first();
        $data['kategori'] = explode('-', $kategori->detail);
        $data['stok'] = [];
        $stok = $data['data']->stok;
        $detail = explode('-', $data['data']->detail);
        $stok_akhir = [];
        $kali = [];
        $data['stok_kata'] = '';
        $sisa = [];
        for($a = 0; $a < count($detail); $a++){
            $kali[$a] = 1;
            for($i = count($detail); $i > $a; $i--){
                $kali[$a] *= $detail[$i-1];
            }
            $sisa[$a] = $stok % $kali[$a];
            $stok_akhir[$a] = floor(($stok - $sisa[$a]) / $kali[$a]);
            $stok = $sisa[$a];
            $data['stok'][] = floor($data['data']->stok / $kali[$a]);
            $data['rincian'][$a] = $kali[$a];
            $data['stok_kata'] .= $stok_akhir[$a].' '.$data['kategori'][$a].' ';
        }
        // dd($data);
        return $data;
    }

    //Convert stok data (dikurang/ditambah)
    public static function convertStok($data){
        $produk = Product::where('kode_barang', $data->kode_barang)->first();
        $data['stok_asal'] = $produk->stok;
        $detail_barang = explode('-', $produk->detail);
        $result = [];
        $data['hasil'] = 0;
        for($a = 0; $a < count($detail_barang); $a++){
            $result[$a] = $data->detail[$a];
            for($i = count($detail_barang); $i > $a; $i--){
                $result[$a] *= $detail_barang[$i-1];
            }
            $data['hasil'] += $result[$a];
        }
        return $data;
    }

}
