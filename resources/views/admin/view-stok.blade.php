@php
    $arr = ['Roko', 'Sabun', 'Makanan'];
@endphp
@extends('layout.sb-admin')
@section('3-4', 'active')
@section('content')
<div class="row">
    <div class="col-md-4 mb-3">
            <img src="{{ url('img/barang').'/'.$data->gambar }}" class="img-thumbnail d-block w-100" style="width: 100%; height: 370px;">
        </div>
        <div class="col-md-8">
            <form action="{{ url('produk/tmbh-stok') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-5 col-md-3" for="kode">Kode Barang</label>
                    <div class="input-group col-7 col-md-9">
                        <input type="text" class="form-control" id="kode" name="kode_barang" value="{{ $data->kode_barang }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-5 col-md-3" for="nama">Nama Barang</label>
                    <div class="input-group col-7 col-md-9">
                        <input type="text" class="form-control" id="nama" name="nama" readonly value="{{ $data->nama }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-5 col-md-3 " for="sisa">Stok Sisa</label>
                    <div class="input-group col-7 col-md-9">
                        <input class="form-control" type="text" value="{{$stok_kata}}" readonly>
                    </div>
                </div>
                @foreach($kategori as $kat)
                <div class="form-group row">
                    <label class="col-5 col-md-3" for="Berat">Tambah {{$kat}}</label>
                    <div class="input-group col-7 col-md-9">
                        <input type="number" min="0" class="form-control" id="Berat" name="detail[]" placeholder="{{ 'Tambah ... '.$kat }}">
                    </div>
                </div>
                @endforeach
                <div class="form-group">
                    <div class="input-group">
                        <button class="btn btn-primary col-12">Tambah Stok Barang</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
@endsection
