@extends('layout.belanja')
@section('title', 'Keranjang')
@section('4', 'active')
@section('hidden', 'd-none d-md-block')
@section('result')
<div class="col-12">
    <h5 class="mt-1 text-success">Checkout - Sederhana</h5>
    <ul class="list-group keranjang d-md-none">
        @php
            $total_harga = 0;
            $jumlah_item = 0;
            $jumlah_berat = 0;
        @endphp
        <li class="list-group-item bg-info text-white text-center h5">
            <i class="fas fa-cart-plus"></i> Keranjangku
            <button type="button" class="close" data-target="#keranjang2" data-toggle="collapse">
                <span aria-hidden="true"><i class="fas fa-plus text-white"></i></span>
            </button>
        </li>
        <div class="collapse show" id="keranjang2">
            @if($carts)
            @foreach($carts as $cart)
            @php
            $kode = $cart['data']->kode_barang;
            $nama = $cart['data']->nama;
            $jumlah = $cart['jumlah'];
            $harga = $cart['data']->harga;
            $total = number_format($jumlah * $harga);
            $berat = $jumlah * $cart['data']->berat;
            $total_harga += $jumlah * $harga;
            $harga = number_format($harga);
            $jumlah_item += $jumlah;
            $jumlah_berat += $berat;
            @endphp
            <li class="list-group-item">
                {{ $jumlah }} <b>{{ $nama}}</b> {{ ' ('.$jumlah.' x '.$harga.") "}}
                <button type="button" class="close">
                    <a href="{{ url('keranjang/hapus').'/'.$cart['data']->kode_barang }}"><i class="fas fa-trash text-danger"></i></a>
                </button> <br>
                {{"=> Rp. ".$total.' ['.$berat.' Kg ]' }}
            </li>
        @endforeach
        @else
            <li class="list-group-item text-center text-danger">
                Keranjang belanja masih kosong
            </li>
            @endif
            <li class="list-group-item bg-info text-white">
                Jumlah : {{$jumlah_item}} item | {{$jumlah_berat}} Kg | Rp. {{number_format($total_harga)}}
            </li>
        </div>
    </ul>
</div>
@if($tersedia)
<div class="col-12">
    <form action="{{ url('keranjang/add') }}" method="post">
        @csrf
        <input type="hidden" name="harga" value="{{ $total_harga }}">
        <input type="hidden" name="item" value="{{ $jumlah_item }}">
        <input type="hidden" name="berat" value="{{ $jumlah_berat }}">
        <input type="hidden" name="ongkir" id="jml-ongkir">
        <div class="row mt-3 mt-md-0">
            <div class="col-12 col-md-6">
                <div class="card border-info mt-1">
                    <div class="collapse show" id="cekongkir">
                        <div class="card-body ongkir">
                            <div>  
                                <label for="metode">Metode Pembayaran:</label>
                                <select name="metode" id="metode" class="custom-select border-info">
                                    <option value="4">Di jemput sendiri</option>
                                    <option value="1">Bank BRI</option>
                                    <option value="2">Bank BCA</option>
                                    <option value="3">Bank Mandiri</option>
                                </select>
                            </div>
                            <div>
                                <label for="kecamatan-1">Kecamatan:</label>
                                <select name="kecamatan" id="kecamatan-1" class="custom-select border-info">
                                    <option value=""></option>
                                    @foreach($ongkir as $ong)
                                    <option value="{{$ong}}">{{$ong}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="desa-1">
                            </div>
                            <div id="harga1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 mt-3 mt-md-1 border-left">
                <div class="card border-info" id="form-buyer">
                    <div class="card-body">
                        <label for="nama">Nama</label>
                        <div class="input-group">
                            @if (auth()->user())
                            <input type="text" data-harga="{{ $total_harga }}" class="form-control border-info" name="nama" id="nama" autocomplete="off" value="{{ auth()->user()->name }}" readonly>
                            @else
                            <input type="text" data-harga="{{ $total_harga }}" class="form-control border-info" name="nama" id="nama" autocomplete="off">
                            @endif
                        </div>
                        <label for="email">Email</label>
                        <div class="input-group">
                            @if(auth()->user())
                            <input type="text" data-jumlah="{{ $jumlah_item }}" class="form-control border-info" name="email" id="email" autocomplete="off" value="{{ auth()->user()->email }}" readonly>
                            @else
                            <input type="text" data-jumlah="{{ $jumlah_item }}" class="form-control border-info" name="email" id="email" autocomplete="off">
                            @endif
                        </div>
                        <label for="notel">No Telepon</label>
                        <div class="input-group">
                            @if(auth()->user())
                            <input type="text" data-berat="{{ $jumlah_berat }}" class="form-control border-info" name="notel" id="notel" autocomplete="off" value="{{ auth()->user()->telepon }}" readonly>
                            @else
                            <input type="text" data-berat="{{ $jumlah_berat }}" class="form-control border-info" name="notel" id="notel" autocomplete="off">
                            @endif
                        </div>
                        <label for="catatan">Catatan:</label>
                        <div class="input-group">
                            <textarea type="text" data-berat="{{ $jumlah_berat }}" class="form-control border-info" name="catatan" id="catatan" autocomplete="off"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group mt-3 mt-md-3" id="btn-kirim">
                <div class="card col-12 mb-3 border-info text-info text-center">
                    <div class="card-body py-2">Total item : <span id="total-item"></span> | Total berat : <span id="total-berat"></span> <br> Ongkir : <span id="ongkir"></span> | Total harga : Rp. <span id="total-harga"></span></div>
                </div>
                <button class="col-12 text-center btn btn-outline-success" type="submit">Kirim ke keranjang</button>
            </div>    
        </div>       
    </form>                                       
</div>
@else
<div class="col-12">
    <div class="card mt-3 mt-md-0">
        <div class="card-header h5 text-center alert-warning">Keranjang masih kosong, silahkan pilih dulu barang jika ingin berbelanja</div>
    </div>
</div>
@endif
<div class="col-md-12 mt-3">
    <div class="card text-white bg-info mb-3">
        <div class="card-header h5 text-center">Cek Status Transaksi</div>
        <div class="card-body">
            <p class="card-text text-justify">
                Apabila anda sudah melakukan pembayaran, dan ingin mengetahui barang yang anda beli sudah dikirim atau belum, silahkan cek status pengiriman dibawah ini dengan No Pesanan yang diberikan sewaktu belanja.
            </p>
        </div>
    </div>
</div>
@endsection 