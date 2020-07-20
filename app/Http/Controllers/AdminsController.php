<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Product;
use App\Ongkir;
use App\Buyer;
use Image;
use File;

class AdminsController extends Controller
{
    public function index()
    {
        $keranjang = DB::table('buyers')
                    ->join('transaksi', 'buyers.kode_pembeli', 'transaksi.kode_pembeli')->get();
        return view('admin.index', compact('keranjang'));
    }

    public function create()
    {
        return view('admin.produk');
    }

    public function detail($id)
    {
        $data = [];
        $data['data'] = Buyer::join('transaksi', 'buyers.kode_pembeli', 'transaksi.kode_pembeli')->where('buyers.kode_pembeli', $id)->first();
        $data['pesan'] = DB::table('pesan')->get();
        $data['barang'] = Buyer::join('carts', 'buyers.kode_pembeli', 'carts.kode_pembeli')->join('products', 'carts.kode_brg', 'products.id')->where('buyers.kode_pembeli', $id)->get();
        return view('admin.detail', $data);
    }

    public function add_produk(Request $data)
    {
        $data->validate([
            'nama'   => 'required',
            'stok'   => 'required',
            'harga'  => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        $id = $this->kodeUnik('id', 'KD');
        $file = $data->file('gambar');
        $eks = $file->getClientOriginalExtension();
        $fileName = date('dmy-').uniqid().'.'.$eks;
        $path = 'img/barang';
        Product::create([
            'id' => $id,
            'nama' => $data->nama,
            'stok' => $data->stok,
            'pack' => $data->pack,
            'bungkus' => $data->bungkus,
            'berat' => $data->berat,
            'harga' => $data->harga,
            'gambar' => $fileName,
            'kategori' => $data->kategori
        ]);
        $file->move($path, $fileName);
        return redirect('produk/add')->with('pesan', [
            'pesan' => 'Barang berhasil di tambahkan',
            'type' => 'success'
        ]);
    }

    public function edit()
    {
        $data = Product::all();
        return view('admin.edit', compact('data'));
    }

    public function edit1($id)
    {
        $data = Product::where('id', $id)->first();
        return view('admin.edit1', compact('data'));
    }

    public function update(Request $request, Product $produk)
    {
        // dd($produk);
        $request->validate([
            'nama'   => 'required',
            'stok'   => 'required',
            'harga'  => 'required',
            'gambar' => 'image|mimes:jpg,png,jpeg'
        ]);
        $gambar = $request->file('gambar');
        $namaLama = Product::where('id', $request->kode_barang)->first();
        $namaLama = $namaLama->gambar;
        if($gambar){
            $eks = $gambar->getClientOriginalExtension();
            $fileName = date('dmy-').uniqid().'.'.$eks;
            $gambar->move('img/barang', $fileName);
            unlink('img/barang/'.$namaLama);
        }else{
            $fileName = $namaLama;
        }
        Product::where('id', $request->kode_barang)->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'berat' => $request->berat,
            'gambar' => $fileName,
            'harga' => $request->harga,
        ]);
        return redirect('produk/edit')->with('pesan', [
            'pesan' => 'Barang berhasil di edit',
            'type' => 'success'
        ]);
    }

    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect('/produk/edit')->with('pesan', [
            'pesan' => 'Barang berhasil di hapus',
            'type' => 'success'
        ]);
    }

    public function search(Request $cari)
    {
        $data = Product::where('nama', 'like', "%$cari->cari%")->get();
        return view('admin.edit', compact('data'));
    }

    public function kodeUnik($col, $simbol){
        $data = Product::orderby($col, 'desc')->first();
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
