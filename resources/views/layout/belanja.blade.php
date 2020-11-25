@extends('layout.main')
@section('script1')
<script>
    $('#form-buyer').hide();
    $('#btn-kirim').hide();
    cekongkir('kecamatan', 'desa', 'harga');
    cekongkir('kecamatan-1', 'desa-1', 'harga1');
    function cekongkir(kecamatan, desa1, harga) {
        $('#'+kecamatan).change(function(){
            var kec = $(this).val();
            var token = $('input:hidden').val();
            $.ajax({
                type : "POST",
                url : "{{ url('/ongkir') }}",
                data : {_token : token, kec : kec},
                success : function(v){
                    if(kec != ''){
                        $('#'+desa1).html('<label for="'+desa1+'-data">Desa:</label><select name="desa" id="'+desa1+'-data" class="custom-select border-info"><option value=""></option></select>');
                        $.each(v, function(k, n){
                            $('#'+desa1+'-data').append(
                                '<option value="'+n.desa+'">'+n.desa+'</option>'
                            );
                        });
                    }else{
                        $('#'+desa1).html('');
                        $('#'+harga).html('');
                        if(kecamatan !== 'kecamatan'){
                            $('#form-buyer').slideUp();
                            $('#btn-kirim').slideUp();
                        }
                    }
                    $('#'+desa1+'-data').change(function(){
                        var desa = $(this).val();
                        $.ajax({
                            type : "POST",
                            url : "{{ url('/ongkir') }}",
                            data : {_token : token, kec : kec, desa : desa},
                            success : function(v){
                                if(desa != ''){
                                    $('#'+harga).html('<label for="'+harga+'-1">Ongkir:</label><input type="text" id="'+harga+'-1" class="form-control '+desa1+' border-info" readonly>');
                                    $('#'+harga+'-1').val('Rp. '+ number_format(v.harga) + '/ Kilogram');
                                    if(kecamatan !== 'kecamatan'){
                                        $('#jml-ongkir').val(v.harga);
                                        $('#form-buyer').slideDown();
                                        $('#btn-kirim').slideDown();
                                        var j_harga = $('#nama').data('harga');
                                        var j_item = $('#email').data('jumlah');
                                        var j_berat = $('#notel').data('berat');
                                        var jumlah_berat = (j_berat * v.harga);
                                        var jumlah = jumlah_berat + j_harga;
                                        $('#total-item').html(j_item);
                                        $('#total-berat').html(j_berat);
                                        $('#total-harga').html(number_format(jumlah));
                                        $('#ongkir').html(number_format(jumlah_berat));
                                    }
                                }else{
                                    $('#'+harga).html('');
                                    if(kecamatan !== 'kecamatan'){
                                        $('#form-buyer').slideUp();
                                        $('#btn-kirim').slideUp();
                                    }
                                }
                            }
                        });
                    });
                }
            });
        });
    }
</script>
@endsection
@section('content')
<div class="col-md-4">
    <div class="row @yield('hidden')">
        <div class="col-12">
            <div class="list-group mt-1" id="kategori">
                <div class="list-group-item bg-info text-white text-center h4">
                    Kategori
                    <button type="button" class="close" data-target="#kategori1" data-toggle="collapse">
                        <span aria-hidden="true"><i class="fas fa-plus text-white"></i></span>
                    </button>
                </div>
                <div class="collapse show" id="kategori1">
                    @for($m = 0; $m < count($menu['menu']); $m++)
                    @if($menu['link'][$m] == $active)
                    <a href="{{ url('/belanja').'/'.$menu['link'][$m] }}" class="list-group-item list-group-item-action bg-secondary text-white">&raquo; {{$menu['menu'][$m]}}</a>
                    @else
                    <a href="{{ url('/belanja').'/'.$menu['link'][$m] }}" class="list-group-item list-group-item-action">{{$menu['menu'][$m]}}</a>
                    @endif
                    @endfor
                </div>
            </div>
        </div>
        <div class="col-12">
            <ul class="list-group mt-3 keranjang">
                <li class="list-group-item bg-info text-white text-center h5">
                    <i class="fas fa-cart-plus"></i> Keranjangku
                    <button type="button" class="close" data-target="#keranjang1" data-toggle="collapse">
                        <span aria-hidden="true"><i class="fas fa-plus text-white"></i></span>
                    </button>
                </li>
                <div class="collapse show" id="keranjang1">
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
        <div class="col-12">
            <div class="card bg-white my-3">
                <div class="card-header h5 text-center text-white bg-info">
                    Cek Ongkos kirim
                    <button type="button" class="close" data-target="#cekongkir" data-toggle="collapse">
                        <span aria-hidden="true"><i class="fas fa-plus text-white"></i></span>
                    </button>
                </div>
                <div class="collapse show" id="cekongkir">
                    <div class="card-body ongkir">
                        <div>
                            Pilih provinsi, kabupaten, dan kecamatan. Harga per Kilogram <br><br>
                            <label for="kecamatan">Kecamatan:</label>
                            <select id="kecamatan" class="custom-select border-info">
                                <option value=""></option>
                                @foreach($ongkir as $ong)
                                <option value="{{$ong}}">{{$ong}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="desa">
                        </div>
                        <div id="harga">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs d-md-none justify-content-center mb-3">
        @for($m = 0; $m < count($menu['menu']); $m++)
            @if($menu['link'][$m] == $active)
                <li class="nav-item">
                    <a class="nav-link active" href="{{ url('/belanja').'/'.$menu['link'][$m]}}">{{$menu['menu'][$m]}}</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/belanja').'/'.$menu['link'][$m]}}">{{$menu['menu'][$m]}}</a>
                </li>
            @endif
        @endfor
    </ul>
</div>
<div class="col-md-8">
    <div class="row">
        @yield('result')
    </div>
</div>
@endsection


