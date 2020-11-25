@extends('layout.sb-admin')
@section('1', 'active')
@section('content')
<div class="col-12 col-md-7 border-info mb-3">
    <div class="collapse show" id="keranjang2">
        <li class="list-group-item bg-info text-white h5">
            <i class="fas fa-cart"></i> {{$keranjang->nama}}
        </li>
        @foreach($barang as $cart)
        <li class="list-group-item d-flex justify-content-between">
            <span>
                {{ $cart['jml_beli'] }} <b>{{ $cart['nama']}}</b> {{ ' ('.$cart['jumlah'].$cart['harga'].") "}}
            </span>
            <span class="h5">
                Rp. {{number_format($cart['jml_harga']) }}
            </span>
        </li>
        @endforeach
        <li class="list-group-item bg-gray-300 d-flex justify-content-between">
            <span>
                Ongkir
            </span>
            <span class="h5">
                Rp. {{number_format($keranjang['ongkir']) }}
            </span>
        </li>
        <li class="list-group-item bg-info text-white d-flex justify-content-between">
            <span>
                Total harga
            </span>
            <span class="h5">
                Rp. {{number_format($total_harga)}}
            </span>
        </li>
    </div>
</div>
<div class="col-12 col-md-5 mb-3">
    <div class="collapse show">
        <li class="list-group-item bg-info text-white">Info pembeli</li>
        <li class="list-group-item">{{$keranjang->nama}}</li>
        <li class="list-group-item">{{$keranjang->email}}</li>
        <li class="list-group-item">{{$keranjang->telepon}}</li>
        <li class="list-group-item">{{$keranjang->alamat}}</li>
        <li class="list-group-item">{{$keranjang->catatan}}</li>
    </div>
</div>
<div class="col-12 col-md-7">
    <form action="{{ url('/admin/keranjang/struk') }}" method="post">
        @csrf
        <button class="btn btn-success col-12" name="id" value="{{ $keranjang->kode_pembeli }}">Print Struk</button>
    </form>
</div>
@endsection
