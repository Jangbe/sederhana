@extends('layout.belanja')
@section('title', 'Belanja Slurr...!')
@section('3', 'active')
@section('hidden', 'd-none d-md-block')
@section('result')
    <div class="col-md-12">
        <form action="{{ url('belanja/keranjang') }}" method="post">
        @csrf
        <div class="card my-3">
            <div class="row no-gutters">
                <div class="col-md-5">
                    <img src="{{ url('img/barang').'/'.$data[0]->gambar }}" class="card-img border" style="width: 100%; height: 320px;">
                </div>
                <div class="col-md-7">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <h5 class="card-title">{{ $data[0]->nama }}</h4>
                        </div>
                        <div class="col-6 col-md-6 text-right">
                            <span class="border h5 px-2 px-md-3 py-1 rounded bg-secondary text-white" id="jumlah-rp">Rp. {{ number_format($data[0]->harga) }}</span>
                        </div>
                    </div>
                    <h6 class="card-title text-muted">[{{ $data[0]->kategori }}] Rp. {{ number_format($data[0]->harga) }}</h6>
                    <p class="card-title text-muted">
                        Stok [{{ $data[0]->stok }}] Berat [{{ $data[0]->berat }}] Kg
                    </p>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-5 col-6 col-form-label">Kode Barang</label>
                        <div class="col-sm-7 col-6">
                            <input type="text" class="form-control" name="id" id="inputEmail3" value="{{ $data[0]->kode_barang }}" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="1" class="col-sm-5 col-6 col-form-label">Jumlah Barang</label>
                        <div class="col-sm-7 col-6">
                            @if($data[0]->stok <= 10)
                                <select name="jumlah" class="custom-select" data-harga="{{ $data[0]->harga }}">
                                    @for($i = 1; $i <= $data[0]->stok; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            @else
                                <input type="number" name="jumlah" class="form-control" id="jml" min="0" max="{{ $data[0]->stok }}" data-harga="{{ $data[0]->harga }}" data-stok="{{ $data[0]->stok }}">
                            @endif
                        </div>
                    </div>
                    
                    <div class="input-group">
                        <button class="btn btn-outline-info col-12" type="submit">Tambah ke keranjang</button>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection