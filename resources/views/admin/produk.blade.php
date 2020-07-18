@extends('layout.sb-admin')
@section('2', 'active')
@section('p-1', 'active')
@section('title', 'Tambah Produk')
@section('content')
<div class="row">
    <div class="col-md-4 mb-3">
        <img src="{{ url('img/barang/default.jpg') }}" class="img-thumbnail d-block w-100">
    </div>
    <div class="col-md-8">
        <form action="{{ url('produk/add') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="nama">Nama Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="text" class="form-control" name="nama" placeholder="Nama barang.." id="nama">
                </div>
                @error('nama')
                    <span class="text-danger ml-2">Nama barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="kode">Stok Barang</label>
                <div class="col-md-9 col-7">
                    <div class="row">
                        <div class="input-group col-12 col-md-4 mb-3">
                            <input type="number" class="form-control" min="0" name="stok" placeholder="Ball.." id="kode">
                        </div>
                        <div class="input-group col-12 col-md-4 mb-3">
                            <input type="number" class="form-control" min="0" name="pack" placeholder="Pack.." id="kode">
                        </div>
                        <div class="input-group col-12 col-md-4">
                            <input type="number" class="form-control" min="0" name="bungkus" placeholder="Bungkus.." id="kode">
                        </div>
                    </div>
                </div>
                @error('stok')
                    <span class="text-danger ml-2">Stok barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="berat">Berat Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="text" class="form-control" name="berat" placeholder="Berat barang.." id="berat">
                </div>
                @error('stok')
                    <span class="text-danger ml-2">Berat barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="harga">Harga Barang</label>
                <div class="input-group col-7 col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number" class="form-control" name="harga" placeholder="Harga barang.." id="harga">
                </div>
                @error('harga')
                    <span class="text-danger ml-2">Harga barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="gambar">Gambar Barang</label>
                <div class="input-group col-7 col-md-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Pilih gambar..</label>
                    </div>
                </div>
                @error('gambar')
                    <span class="text-danger ml-2">Gambar barang harus di pilih.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="kategori">Kategori Barang</label>
                <div class="input-group col-7 col-md-9">
                    <select name="kategori" class="custom-select" id="kategori">
                        <option value="Roko">Roko</option>
                        <option value="Sabun">Sabun</option>
                        <option value="Makanan">Makanan</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <button class="btn btn-primary col-12">Tambah Barang</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
