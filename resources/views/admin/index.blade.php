@extends('layout.admin')
@section('1', 'active')
@section('content')
<div class="col-md-8 col-12">
    <div class="list-group">
        <a href="#" class="list-group-item list-group-item-action active text-center">
            Pesanan
        </a>
        @foreach($keranjang as $cart)
        @if($cart->kode_pesan == 1)
            <a href="{{ url('admin/keranjang').'/'.$cart->kode_pembeli }}" class="list-group-item list-group-item-action list-group-item-warning text-center d-flex justify-content-between align-items-center">
                {{$cart->nama}}
                <span>Rp. {{ number_format($cart->total_harga) }}</span>
            </a>
        @elseif($cart->kode_pesan == 2)
            <a href="{{ url('admin/keranjang').'/'.$cart->kode_pembeli }}" class="list-group-item list-group-item-action list-group-item-info text-center d-flex justify-content-between align-items-center">
                {{$cart->nama}}
                <span>Rp. {{ number_format($cart->total_harga) }}</span>
            </a>
        @elseif($cart->kode_pesan == 3)
            <a href="{{ url('admin/keranjang').'/'.$cart->kode_pembeli }}" class="list-group-item list-group-item-action list-group-item-primary text-center d-flex justify-content-between align-items-center">
                {{$cart->nama}}
                <span>Rp. {{ number_format($cart->total_harga) }}</span>
            </a>
        @elseif($cart->kode_pesan == 4)
            <a href="{{ url('admin/keranjang').'/'.$cart->kode_pembeli }}" class="list-group-item list-group-item-action list-group-item-success text-center d-flex justify-content-between align-items-center">
                {{$cart->nama}}
                <span>Rp. {{ number_format($cart->total_harga) }}</span>
            </a>
        @else
        @endif
        @endforeach
    </div>
    <div class="col-4">

    </div>
</div>
@endsection