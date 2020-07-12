@php
    $arr = ['Roko', 'Sabun', 'Makanan'];
@endphp
@extends('layout.admin')
@section('title', 'Edit Produk')
@section('5', 'active')
@section('p-2', 'active')
@section('content')
<div class="col-md-4 mb-3">
        <img src="{{ url('img/barang').'/'.$data->gambar }}" class="img-thumbnail d-block w-100" style="width: 100%; height: 370px;">
    </div>
    <div class="col-md-8">
        <form action="{{ url('produk/edit/update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="kode">Kode Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="text" class="form-control" id="kode" name="kode_barang" value="{{ $data->kode_barang }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="nama">Nama Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama barang.." value="{{ $data->nama }}">
                </div>
                @error('nama')
                    <span class="text-danger ml-2">Nama barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="stok">Stok Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok barang.." value="{{ $data->stok }}">
                </div>
                @error('stok')
                    <span class="text-danger ml-2">Stok barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="Berat">Berat Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="number" class="form-control" id="Berat" name="berat" placeholder="Berat barang.." value="{{ $data->berat }}">
                </div>
                @error('stok')
                    <span class="text-danger ml-2">Stok barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="Harga">Harga Barang</label>
                <div class="input-group col-7 col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number" class="form-control" id="Harga" name="harga" placeholder="Harga barang.." value="{{ $data->harga }}">
                </div>
                @error('harga')
                    <span class="text-danger ml-2">Harga barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="gambar">Gambar Barang</label>
                <div class="input-group col-7 col-md-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gambar" name="gambar" readonly>
                        <label class="custom-file-label" for="gambar">Pilih gambar..</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <button class="btn btn-primary col-12">Tambah Barang</button>
                </div>
            </div>
        </form>
    </div>
@endsection