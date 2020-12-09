<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Jsonable;
use App\Http\Controllers\Controller;
use App\Product;
use App\Buyer;
use App\Cart;
use App\Kategori;
use App\Transaksi;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Inline\Element\Strong;

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
        $data['kategori'] = Kategori::getKategori();
        return view('admin.produk', $data);
    }

    public function detail($id)
    {
        $data = [];
        $data['data'] = Buyer::join('transaksi', 'buyers.kode_pembeli', 'transaksi.kode_pembeli')->where('buyers.kode_pembeli', $id)->firstOrFail();
        $data['pesan'] = DB::table('pesan')->get();
        $data['barang'] = Buyer::join('carts', 'buyers.kode_pembeli', 'carts.kode_pembeli')->join('products', 'carts.kode_brg', 'products.kode_barang')->where('buyers.kode_pembeli', $id)->get();
        return view('admin.detail', $data);
    }

    public function keranjang($id){
        $data['keranjang'] = Buyer::join('transaksi', 'buyers.kode_pembeli', 'transaksi.kode_pembeli')->where(['buyers.kode_pembeli' => $id])->firstOrFail();
        $data['barang'] = Cart::join('products','carts.kode_brg','products.kode_barang')->where(['carts.kode_pembeli' => $id])->get();
        $data['total_harga'] = $data['keranjang']->total_harga + $data['keranjang']->ongkir;
        return view('admin.keranjang', $data);
    }

    public function struk(Request $request){
        Transaksi::where('kode_pembeli', $request->id)->update(['kode_pesan' => 3]);
        $products = Product::select(['*', 'products.detail as stok_default'])->join('carts', 'products.kode_barang', 'carts.kode_brg')->join('kategori', 'products.kategori', 'kategori.slug')->where('carts.kode_pembeli', $request->id)->get();
        $buyer = Buyer::join('transaksi', 'buyers.kode_pembeli', 'transaksi.kode_pembeli')->where('buyers.kode_pembeli', $request->id)->firstOrFail();
        $index = 0;
        $m_beli = 0;
        $m_satuan = 0;
        foreach($products as $product){
            $jml_beli = $product->jml_beli;
            $nama = $product->singkatan;
            $jml_harga = number_format($product->jml_harga, 0, ',', '.');
            $detail = Product::getStok($product->kode_barang);
            $default = explode('-', $product->stok_default);
            $satuan = $detail['kategori'][count($detail['kategori']) - 1];
            // dd($detail);
            for($i = count($detail['rincian']) - 1; $i >= 0; $i--){
                if($jml_beli >= $detail['rincian'][$i] && $jml_beli % $default[$i] == 0){
                    $satuan = $detail['kategori'][$i];
                    $jml_beli = $jml_beli / $detail['rincian'][$i];
                }
            }
            $m_beli = Buyer::max($jml_beli, $m_beli);
            $satuan = str_replace(['a','i','u','e','o','ng'], '', $satuan);
            $m_satuan = Buyer::max($satuan, $m_satuan);
            $result[$index] = Buyer::setText($jml_beli, $m_beli).Buyer::setText($satuan, $m_satuan).Buyer::setText($nama, 11).'Rp '.Buyer::setText($jml_harga, 8); //Total harus 32 huruf: (2+1) + (4+1) + (11+1) + (11+1);
            $index++;
        }
        $data = [
            'barang' => $result,
            'nama' => $buyer->nama,
            'total_harga' => $buyer->total_harga,
            'kode' => $buyer->id,
            'ongkir' => $buyer->ongkir,
        ];
        Buyer::setTextStruk($data);
        return redirect('admin')->with('pesan', [
            'pesan' => 'Struk berhasil dicetak',
            'type' => 'success'
        ]);
    }

    public function create_struk(){
        $data = Cart::getCart();
        $data['carts'] = Cart::cart();
        $data['products'] = Product::join('kategori', 'kategori.slug', 'products.kategori')->paginate(2);
        return view('admin.struct', $data);
    }

    public function add_produk(Request $data)
    {
        $data->validate([
            'nama'   => 'required',
            'harga'  => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg'
        ]);
        $id = $this->kodeUnik('kode_barang', 'KD');
        $file = $data->file('gambar');
        $eks = $file->getClientOriginalExtension();
        $content = $file->getContent();
        $fileName = date('dmy-').uniqid().'.'.$eks;

        $gambar = Storage::disk('google')->put($fileName, $content);
        // dd($gambar);
        $detail = $data->detail;
        $detail[] = 1;
        Product::create([
            'kode_barang' => $id,
            'nama' => $data->nama,
            'singkatan' => $data->singkatan,
            'stok' => 0,
            'berat' => $data->berat/1000,
            'harga' => $data->harga,
            'gambar' => $fileName,
            'kategori' => $data->kategori,
            'detail' => implode('-', $detail)
        ]);

        return redirect('produk/add')->with('pesan', [
            'pesan' => 'Barang berhasil di tambahkan',
            'type' => 'success'
        ]);
    }

    public function edit()
    {
        $data['data'] = Product::all();
        return view('admin.edit', $data);
    }

    public function edit1($id)
    {
        $data = Product::where('kode_barang', $id)->firstOrFail();
        return view('admin.edit1', compact('data'));
    }

    public function tmbh_stok(){
        $data = Product::all();
        return view('admin.tambah-stok', compact('data'));
    }

    public function view_stok($kode){
        $data['data'] = Product::where('kode_barang', $kode)->firstOrFail();
        $data = Product::getStok($kode);
        return view('admin.view-stok', $data);
    }

    public function add_stok(Request $data){
        $result = Product::convertStok($data);
        Product::where('kode_barang', $data->kode_barang)->update(
            ['stok' => $result['hasil'] + $result['stok_asal']]
        );
        return redirect('produk/tmbh-stok')->with('pesan', [
            'pesan' => 'Stok barang berhasil ditambah',
            'type' => 'success'
        ]);
    }

    public function update(Request $request, Product $produk)
    {
        $request->validate([
            'nama'   => 'required',
            'harga'  => 'required',
            'gambar' => 'image|mimes:jpg,png,jpeg'
        ]);
        $gambar = $request->file('gambar');
        $namaLama = Product::where('kode_barang', $request->kode_barang)->firstOrFail();
        $namaLama = $namaLama->gambar;
        if($gambar){
            $eks = $gambar->getClientOriginalExtension();
            $fileName = date('dmy-').uniqid().'.'.$eks;
            $content = $gambar->getContent();
            $gambar->move('img/barang', $fileName);
            Storage::disk('google')->put($fileName, $content);
            Storage::disk('google')->delete($namaLama);
        }else{
            $fileName = $namaLama;
        }
        Product::where('kode_barang', $request->kode_barang)->update([
            'nama' => $request->nama,
            'singkatan' => $request->singkatan,
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
        $data = Product::where('kode_barang', $id)->firstOrFail();
        Storage::disk('google')->delete(Ghelper::getPathId($data->gambar));
        Product::where('kode_barang', $id)->delete();
        return redirect('/produk/edit')->with('pesan', [
            'pesan' => 'Barang berhasil di hapus',
            'type' => 'success'
        ]);
    }

    public function search(Request $cari)
    {
        $data = Product::join('kategori', 'kategori.slug', 'products.kategori')->where('nama', 'like', "%$cari->cari%")->paginate(2);
        if($cari->json){
            return response()->json($data);
        }else{
            return view('admin.edit', compact('data'));
        }
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

    public function get_detail(Request $get){
        $data = Kategori::where('slug', $get->slug)->firstOrFail();
        echo json_encode($data);
    }

    public function category(){
        $data['data'] = Kategori::getKategori();
        return view('admin.category', $data);
    }

    public function add_category(Request $request){
        $request->validate([
            'nama' => 'required',
            'slug' => 'required'
        ]);
        Kategori::create(['nama_kategori' => $request->nama, 'slug' => $request->slug, 'detail' => implode('-', $request->detail)]);
        return redirect('admin/category')->with('pesan', [
            'pesan' => 'Kategori berhasil ditambahkan',
            'type' => 'success'
        ]);
    }

    public function edit_category(Request $data){
        echo json_encode(Kategori::getDetail($data->id));
    }

    public function edt_cate(Request $data){
        Kategori::updateKategori($data);
        return redirect('admin/category')->with('pesan', [
            'pesan' => 'Kategori berhasil diubah',
            'type' => 'success'
        ]);
    }

    public function delete_category(Request $data){
        Kategori::where('id', $data->id)->delete();
        return redirect('admin/category')->with('pesan', [
            'pesan' => 'Kategori berhasil dihapus',
            'type' => 'success'
        ]);
    }

}
