<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Buyer;
use App\Cart;
use App\Transaksi;

class CartsController extends Controller
{
    public function keranjang()
    {
        $data = Cart::getCart();
        $data['barang'] = Product::all();
        $data['carts'] = Cart::cart();
        $data['menu'] = Cart::menu();
        $data['ongkir'] = Cart::_ongkir();
        $data['active'] = '';
        $data['tersedia'] = $data['carts'] ? true : false;
        if(auth()->user()){
            $data['nama'] = auth()->user()->name;
            $data['email'] = auth()->user()->email;
            $data['telepon'] = auth()->user()->telepon;
            $data['readonly'] = 'readonly';
        }else{
            $data['nama'] = old('nama');
            $data['email'] = old('email');
            $data['telepon'] = old('notel');
            $data['readonly'] = '';
        }
        return view('belanja.keranjang', $data);
    }

    public function destroy($id)
    {
        $item = 'item_'.$id;
        session()->forget($item);
        return back(302)->with('pesan', [
            'pesan' => 'Barang telah dihapus dari keranjang',
            'type' => 'success'
        ]);
    }

    public function store(Request $request)
    {
        $message = [
            'required' => 'Field :attribute tidak boleh kosong',
            'numeric' => 'Field ini harus dengan angka',
            'max' => 'Field :attribute tidak boleh lebih dari :max huruf',
            'email' => 'Harus memakai email yang benar',
            'unique' => 'Field :attribute harus uniq, ini sudah dipakai oleh orang lain'
        ];
        if(!$request->admin){
            $this->validate($request, [
                'email' => 'required|unique:buyers|email',
                'nama' => 'required|max:20',
                'notel' => 'numeric|required',
                'alamat' => 'required'
            ], $message);
            $email = $request->email;
            $notel = $request->notel;
            $alamat = $request->alamat;
            $catatan = $request->catatan;
            $metode = $request->metode;
            //code untuk mengirim nomer transaksi ke alamat e-mail buyer
        }else{
            $email = '';
            $notel = '';
            $alamat = '';
            $catatan = '';
            $metode = 4;
        }
        $kode_pembeli = $this->_kodeUnik('buyers', 'kode_pembeli', 'PM');

        Buyer::create([
            'kode_pembeli' => $kode_pembeli,
            'nama' => $request->nama,
            'email' => $email,
            'telepon' => $notel,
            'alamat' => $alamat,
            'catatan' => $catatan
            ]);

        $data = Cart::cart();
        $harga = 0;
        foreach($data as $dat){
            if($metode == 4){
                $stok = $dat['data']->stok;
                $stok -= $dat['jumlah'];
                Product::where('kode_barang', $dat['data']->kode_barang)->update(['stok' => $stok]);
            }
            $kode_cart = $this->_kodeUnik('carts', 'kode_cart', 'KP');
            $jml_harga = $dat['jumlah'] * $dat['data']->harga;
            Cart::create([
                'kode_cart' => $kode_cart,
                'kode_pembeli' => $kode_pembeli,
                'kode_brg' => $dat['data']->kode_barang,
                'tgl_beli' => time(),
                'total_berat' => $dat['jumlah'] * $dat['data']->berat,
                'jml_beli' => $dat['jumlah'],
                'jml_harga' => $jml_harga
            ]);
            $harga += $jml_harga;
            session()->forget('item_'.$dat['data']->kode_barang);
        }
        // $ongkir = DB::table('ongkirs')->where(['kec' => $request->kecamatan, 'desa' => $request->desa])->first();
        // if($request->metode == 4){
        //     $ongkir = 0;
        // }else{
        //     $ongkir = $ongkir->harga;
        //     $ongkir = $ongkir * $request->berat;
        // }
        $id_transaksi = $this->_kodeUnik('transaksi', 'id', date('Ymd'));
        $pesan = $metode == 4? 2 : 1;
        Transaksi::create([
            'id' => $id_transaksi,
            'kode_pembeli' => $kode_pembeli,
            'ongkir' => 0,
            'total_harga' => $harga,
            'kode_pesan' => $pesan,
            'metode' => $metode
        ]);

        return redirect('/belanja')->with('pesan', [
            'pesan' => 'Barang-barang sudah dimasukan ke keranjang, silahkan bayar pesanan anda dengan nomer transaksi '.$id_transaksi.', Nomer transaksi juga sudah dikirim ke alamat e-mail kamu',
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
