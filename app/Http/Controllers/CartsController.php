<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Buyer;
use App\Cart;
use Auth;

class CartsController extends Controller
{
    public function keranjang(Request $data)
    {
        $produk = Product::where('kode_barang', $data->id)->first();
        if($data->jumlah == 0){
            return redirect('/belanja')->with('pesan', [
                'pesan' => 'Barang gagal dimasukan ke keranjang, jumlah tidak boleh 0',
                'type' => 'danger'
            ]);
        }else{
            if($data->jumlah <= $produk->stok){
                session(['item_'.$data->id => $data->jumlah]);
                return redirect('/belanja')->with('pesan', [
                    'pesan' => 'Barang telah dimasukan ke keranjang',
                    'type' => 'success'
                ]);
            }else{
                return redirect('/belanja')->with('pesan', [
                    'pesan' => 'Barang gagal dimasukan ke keranjang, jumlah beli melebihi stok!',
                    'type' => 'danger'
                ]);
            }
        }
    }

    public function destroy($id)
    {
        $item = 'item_'.$id;
        session()->forget($item);
        return redirect('/belanja')->with('pesan', [
            'pesan' => 'Barang telah dihapus dari keranjang',
            'type' => 'success'
        ]);
    }

    public function store(Request $request)
    {
        $data = [];
        foreach(session()->all() as $key => $value){
            if(substr($key, 0, 5) == 'item_'){
                $item = substr($key, 5, (strlen($key) -5));
                $data[] = [
                    'barang' => Product::where('kode_barang', $item)->first(),
                    'jumlah' => $value
                ];
            }
        }
        $alamat = $request->kecamatan.'-'.$request->desa;
        $kode_pembeli = $this->_kodeUnik('buyers', 'kode_pembeli', 'PM');
        
        Buyer::create([
            'kode_pembeli' => $kode_pembeli,
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->notel,
            'alamat' => $alamat,
            'catatan' => $request->catatan
        ]);
        foreach($data as $dat){
            $stok = $dat['barang']->stok;
            $stok = $stok - $dat['jumlah'];
            Product::where('kode_barang', $dat['barang']->kode_barang)->update(['stok' => $stok]);
            $kode_cart = $this->_kodeUnik('carts', 'kode_cart', 'KP');
            Cart::create([
                'kode_cart' => $kode_cart,
                'kode_pembeli' => $kode_pembeli,
                'kode_brg' => $dat['barang']->kode_barang,
                'tgl_beli' => time(),
                'total_berat' => $dat['jumlah'] * $dat['barang']->berat,
                'jml_beli' => $dat['jumlah'],
                'jml_harga' => $dat['jumlah'] * $dat['barang']->harga
            ]);
            session()->forget('item_'.$dat['barang']->kode_barang);
        }
        $ongkir = DB::table('ongkirs')->where(['kec' => $request->kecamatan, 'desa' => $request->desa])->first();
        if($request->metode == 4){
            $ongkir = 0;
        }else{
            $ongkir = $ongkir->harga;
            $ongkir = $ongkir * $request->berat;
        }
        $id_transaksi = date('Ymd');
        $id_transaksi = $this->_kodeUnik('transaksi', 'id', $id_transaksi);
        DB::table('transaksi')->insert([
            'id' => $id_transaksi,
            'kode_pembeli' => $kode_pembeli,
            'ongkir' => $ongkir,
            'total_harga' => $request->harga,
            'total_bayar' => 0,
            'kode_pesan' => 1
        ]);
        return redirect('/belanja')->with('pesan', [
            'pesan' => 'Barang-barang sudah dimasukan ke keranjang, silahkan bayar pesanan anda dengan nomer transaksi '.$id_transaksi,
            'type' => 'success'
        ]);
    }
    
    public function _kodeUnik($table, $col, $simbol){
        $data = DB::table($table)->orderby($col, 'desc')->first();
        if($data){
            $akhirkode = substr($data->$col,-4)+1;
        }else{
            $akhirkode = 1;
        }
    
        if ($akhirkode <= 9){
            $kodebaru = $simbol."000".$akhirkode;
        }else if($akhirkode <= 99){
            $kodebaru = $simbol."00".$akhirkode;
        }else if($akhirkode <= 999){
            $kodebaru = $simbol."0".$akhirkode;
        }else if($akhirkode <= 9999){
            $kodebaru = $simbol.$akhirkode;
        }
        return $kodebaru;
    }
}
