@extends('layout.sb-admin')
@section('1-3', 'active')
@section('content')
    <div class="col-md-8 col-12">
        <div class="form-group">
            <input type="text" id="cari" placeholder="cari nama barang..." class="form-control mb-3">
        </div>
        <ul class="list-group mb-2 barang">
            <li class="list-group-item bg-success text-white d-flex justify-content-between">
                Nama Barang
                <span>Opsi</span>
            </li>
        @foreach ($products as $product)
        <li class="list-group-item">
            <form action="{{url('belanja/keranjang')}}" method="post">
                @csrf
                <input type="hidden" name="kode_barang" value="{{$product->kode_barang}}">
                <span class="d-md-inline-block d-none">{{$product->nama}}</span>
                <span class="d-sm-inline-block d-md-none">{{$product->singkatan}}</span>
                <button class="btn btn-success float-right ml-2" type="submit"><i class="fas fa-plus"></i></button>
                @for ($i = count(explode('-', $product->detail))-1; $i >= 0; $i--)
                <input type="number" name="detail[{{$i}}]" class="form-control col-md-2 col-3 d-inline-block float-right" placeholder="{{str_replace(['a','i','u','e','o','ng'], '', explode('-', $product->detail)[$i])}}">
                @endfor
            </form>
        </li>
        @endforeach
    </ul>
    {{$products->links()}}
    </div>
    @csrf
    <div class="col-4">
        <form action="{{ url('keranjang/add') }}" method="post">
            @csrf
            <input type="hidden" name="admin" value="true">
            <input type="hidden" name="ongkir" id="jml-ongkir">
            <input type="text" class="form-control" minlength="5" maxlength="20" name="nama" placeholder="Nama...">
            <button class="btn btn-success mb-2 col-12">Tambahkan</button>
        </form>
        <ul class="list-group">
            <li class="list-group-item bg-success text-white">Belanjaan</li>
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
            <li class="list-group-item bg-success text-white">
                Jumlah : {{$jumlah_item}} item | {{$jumlah_berat}} Kg | Rp. {{number_format($total_harga)}}
            </li>
        </ul>
    </div>
@endsection
@section('script')
    <script>
        $('#cari').keyup(function(){
            var val = $(this).val();
            var csrf = $('input[name=_token]').val();
            $('.barang.list-group').empty();
            $('.barang.list-group').append('<li class="list-group-item bg-success text-white d-flex justify-content-between">Nama Barang<span>Opsi</span></li>');
            $.ajax({
                method: 'post',
                url: "{{url('/produk/cari')}}",
                data: {_token: csrf, cari: val, json: true},
                success: function(result){
                    // console.log(result);
                    $('.barang.list-group').empty();
                    $('.barang.list-group').append('<li class="list-group-item bg-success text-white d-flex justify-content-between">Nama Barang<span>Opsi</span></li>');
                    $.each(result.data, function(k, v){
                        $('.barang.list-group').append(setTag(v));
                    });
                    $('ul.pagination').empty();
                }
            });
        });
        function setTag(data){
            var append = '<li class="list-group-item"><form action="{{url("belanja/keranjang")}}" method="post">@csrf<input type="hidden" name="kode_barang" value="'+data.kode_barang+'"><span class="d-md-inline-block d-none">'
            +data.nama+'</span><span class="d-sm-inline-block d-md-none">'+
            data.singkatan+'</span><button class="btn btn-success float-right ml-2"><i class="fas fa-plus"></i></button>';
            var text = data.detail.split('-');
            for(var i = text.length -1; i >= 0; i--){
                var a = text[i].replace(/a|i|u|e|o|ng/gi, '');
                append += '<input type="number" name="detail['+i+']" class="form-control col-md-2 col-3 d-inline-block float-right" placeholder="'+a+'">';
            }
            append += '</form></li>';
            return append;
        }
    </script>

@endsection
