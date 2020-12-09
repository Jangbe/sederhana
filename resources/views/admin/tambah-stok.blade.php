@extends('layout.sb-admin')
@section('title', 'Tambah Stok Produk')
@section('3-4', 'active')
@section('content')
<div class="col-12">
    <form action="{{ url('produk/cari') }}" method="post">
    @csrf
    <div class="form-group">
        <div class="input-group">
            <input type="text" class="form-control" name="cari" autocomplete="off" placeholder="Cari barang...">
            <div class="input-group-append">
                <button class="btn btn-secondary"  type="submit">Cari</button>
            </div>
        </div>
    </div>
    </form>
</div>
<div class="col-12">
    <table class="table table-hover">
        <thead class="bg-primary text-light text-center">
            <tr>
                <th scope="col">Gambar <span class="d-none d-md-inline">Produk</span></th>
                <th scope="col">Nama <span class="d-none d-md-inline">Produk</span></th>
                <th scope="col">Tambah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $dta)
            <tr>
                <td><img src="{{ Ghelper::glinkFoto($dta->gambar) }}" class="img-thumbnail" style="width:60px;height:60px;"></td>
                <td>{{ $dta->nama }}</td>
                <td class="text-right">
                    <a href="{{ url("produk/tmbh-stok/".$dta->kode_barang) }}" class="btn btn-success"><i class="fas fa-plus-circle"></i><span class="d-none d-md-inline"> Tambah</span></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
