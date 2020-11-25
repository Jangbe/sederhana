@extends('layout.belanja')
@section('title', 'Keranjang')
@section('4', 'active')
@section('hidden', 'd-none d-md-block')
@section('result')
<div class="col-12">
    <h5 class="mt-1 text-success">Checkout - Sederhana</h5>
    <ul class="list-group keranjang d-md-none">
        <li class="list-group-item bg-info text-white text-center h5">
            <i class="fas fa-cart-plus"></i> Keranjangku
            <button type="button" class="close" data-target="#keranjang2" data-toggle="collapse">
                <span aria-hidden="true"><i class="fas fa-plus text-white"></i></span>
            </button>
        </li>
        <div class="collapse show" id="keranjang2">
            @if($carts)
            @foreach($detail as $cart)
            <li class="list-group-item">
                {{ $cart['jumlah'] }} <b>{{ $cart['nama']}}</b> {{ ' ('.$cart['jumlah'].' x '.$cart['harga'].") "}}
                <button type="button" class="close">
                    <a href="{{ url('keranjang/hapus').'/'.$cart['kode'] }}"><i class="fas fa-trash text-danger"></i></a>
                </button> <br>
                {{"=> Rp. ".$cart['total'].' ['.$cart['berat'].' Kg ]' }}
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
        <input type="hidden" name="ongkir" id="jml-ongkir">
        <div class="row mt-3 mt-md-0">
            <div class="col-12 col-md-6">
                <div class="card border-info mb-2" id="form-buyer">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <div class="input-group">
                                <input type="text" data-harga="{{ $total_harga }}" class="form-control border-info" name="nama" id="nama" autocomplete="off" value="{{$nama}}" {{$readonly}}>
                            </div>
                            @error('nama')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <div class="input-group">
                                <input type="text" data-jumlah="{{ $jumlah_item }}" class="form-control border-info" name="email" id="email" autocomplete="off" value="{{$email}}" {{$readonly}}>
                            </div>
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notel">No Telepon</label>
                            <div class="input-group">
                                <input type="text" data-berat="{{ $jumlah_berat }}" class="form-control border-info" name="notel" id="notel" autocomplete="off" value="{{$telepon}}" {{$readonly}}>
                            </div>
                            @error('notel')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan:</label>
                            <div class="input-group">
                                <textarea type="text" data-berat="{{ $jumlah_berat }}" class="form-control border-info" name="catatan" id="catatan" autocomplete="off">{{old('catatan')}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 border-left">
                <div class="card border-info">
                    <div class="collapse show" id="cekongkir">
                        <div class="card-body ongkir">
                            <div>
                                {{-- <label for="kecamatan-1">Kecamatan:</label>
                                <select name="kecamatan" id="kecamatan-1" class="custom-select border-info">
                                    <option value=""></option>
                                    @foreach($ongkir as $ong)
                                    <option value="{{$ong}}">{{$ong}}</option>
                                    @endforeach
                                </select> --}}
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <div class="input-group">
                                        <input type="text" name="alamat" class="form-control border-info" id="alamat" value="{{old('alamat')}}">
                                    </div>
                                    @error('alamat')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div id="desa-1">
                            </div>
                            <div id="harga1">
                            </div>
                            <div>
                                <label for="metode">Metode Pembayaran:</label>
                                <select name="metode" id="metode" class="custom-select border-info">
                                    <option value="4">Di jemput sendiri</option>
                                    <option value="1">Bank BRI</option>
                                    <option value="2">Bank BCA</option>
                                    <option value="3">Bank Mandiri</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="input-group mt-3 mt-md-3" id="btn-kirim">
                <div class="card col-12 mb-3 border-info text-info text-center mt-1">
                    <div class="card-body py-2">Total item : <span id="total-item">{{$jumlah_item}}</span> | Total berat : <span id="total-berat">{{$jumlah_berat}} kg</span> <br> Ongkir : <span id="ongkir"></span> | Total harga : Rp. <span id="total-harga">{{number_format($total_harga)}}</span></div>
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
