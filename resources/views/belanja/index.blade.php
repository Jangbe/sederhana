@extends('layout.belanja')
@section('title', 'Belanja Slurr...!')
@section('3', 'active')
@section('hidden', 'd-none d-md-block')
@section('result')
@foreach($barang as $brg)
<div class="col-md-3 mt-1 mb-2 col-6">
    <a href="{{ url('belanja/detail').'/'.$brg['kode_barang'] }}" style="text-decoration:none; height: 100px;">
        <div class="card border-info">
            <img src="{{ url('img/barang').'/'.$brg['gambar']}}" class="card-img-top" style="width: 100%; height: 180px">
            <div class="card-body bg-info">
                <span class="text-white">{{ $brg['singkatan'] }}</span>
            </div>
        </div>
    </a>
</div>
@endforeach
@endsection
