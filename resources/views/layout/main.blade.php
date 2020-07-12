<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ url('css/app.css')}}">
    <link rel="stylesheet" href="{{ url('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ url('font/css/all.css')}}">
    <title>Sederhana | @yield('title')</title>
    <style>
        }.anagram{
            font-family: fantasy;
            color: red;
        }
        @font-face{
            font-family: "Allura";
            src: url("{{ url('font/Allura-Regular.otf')}}");
        }.allura{
            font-family: "Allura";
        }.allura span{
            color: lightblue;
            text-shadow: 4px 0 0 royalblue;
        }.allura p{
            color: blue;
            font-family: fantasy;
        }
        
    </style>
</head>
<body>
    <div class="container mb-4">
        <div class="row mb-4">
            <div class="col-12 text-center allura">
                <a style="text-decoration:none;" href="{{ url('/') }}"><span class="mt-6 display-1">Sederhana</span></a>
                <p style="margin-top: -30px;">Jl. Garut Depan Masjid Agung Mangunreja Tasikmalaya</p>
                <form action="{{ url('belanja/cari') }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="input-group" style="font-family:Verdana, Geneva, Tahoma, sans-serif;">
                        <input autocomplete="off" type="text" class="form-control" name="cari" placeholder="Cari barang disini....">
                        <div class="input-group-append">
                            <button class="btn btn-info" type="submit">Cari</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="col-12 mb-4">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item">
                      <a class="nav-link @yield('1')" href="{{ url('/') }}"><i class="fas fa-home"></i><span class="d-none d-md-inline"> Beranda</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link @yield('2')" href="{{ url('/about') }}"><i class="fas fa-cog"></i><span class="d-none d-md-inline"> Tentang</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link @yield('3')" href="{{ url('/belanja') }}"><i class="fas fa-cart-plus"></i><span class="d-none d-md-inline"> Belanja</span></a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link @yield('4')" href="{{ url('/keranjang') }}"><i class="fas fa-shopping-cart"></i><span class="d-none d-md-inline"> Checkout</span></a>
                    </li>
                    @if(auth()->user())
                        <li class="nav-item">
                            <a href="{{ url('profile') }}" class="nav-link"><i class="fas fa-user"></i><span class="d-none d-md-inline"> Profile</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i><span class="d-none d-md-inline"> Logout</span></a>
                        </li>
                    @else
                        <li class="nav-item">
                          <a class="nav-link" href="{{ url('/register') }}"><i class="fas fa-user-plus"></i><span class="d-none d-md-inline"> Daftar</span></a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="{{ url('/login') }}"><i class="fas fa-sign-in-alt"></i><span class="d-none d-md-inline"> Masuk</span></a>
                        </li>
                    @endif
                  </ul>
            </div>
            {{-- <div class="col-12 d-md-none mb-3">
                <nav class="navbar navbar-expand-lg navbar-light border-top border-bottom">
                    <a class="navbar-brand" href="{{ url('/')}}">Menu</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                            <a class="nav-item nav-link @yield('1')" href="{{ url('/')}}">Beranda</span></a>
                            <a class="nav-item nav-link @yield('2')" href="{{ url('/about')}}">Tentang</a>
                            <a class="nav-item nav-link @yield('3')" href="{{ url('/belanja')}}">Belanja</a>
                            <a class="nav-item nav-link @yield('4')" href="{{ url('/keranjang')}}">Keranjang</a>
                            @if(auth()->user())
                            @if(auth()->user()->role == 'admin')
                            <a class="nav-item dropdown nav-link @yield('5') dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Produk
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item @yield('p-1')" href="{{ url('/produk/add')}}">Tambah Produk</a>
                                <a class="dropdown-item @yield('p-2')" href="{{ url('/produk/edit')}}">Edit Produk</a>
                            </div>
                            @endif
                            <a class="nav-item nav-link" href="{{ url('/logout')}}">Logout</a>
                            @else
                            <a class="nav-item nav-link" href="{{ url('/register')}}">Daftar</a>
                            <a class="nav-item nav-link" href="{{ url('/login')}}">Masuk</a>
                            @endif
                        </div>
                    </div>
                </nav>
            </div> --}}
            @if(session('pesan'))
            <div class="col-12">
                <div class="alert alert-{{session('pesan')['type']}} text-center">
                    {{session('pesan')['pesan']}}
                </div>
            </div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="{{ url('js/jquery.js')}}"></script>
    <script src="{{ url('js/app.js')}}"></script>
    <script src="{{ url('js/bootstrap.js')}}"></script>
    <script src="{{ url('font/js/all.js')}}"></script>
    <script src="{{ url('js/number_format.js')}}"></script>
    <script>
// $.ajax({
//     type: "GET",
//     url: "https://x.rajaapi.com/MeP7c5ne23EtRlULiNs4VmgNCpkdLrpWFUN1L2TuiOaKlpabWj40eX0cLb/m/wilayah/kecamatan/",
//     data: { idkabupaten: 3206 },
//     success: function (kec) {
//         // console.log(kec.data);
//         $.each(kec.data, function (k, v) {
//             // console.log(v);
//             kecam(v.id, v.name);
//         });
//     }
// });
// function kecam(id, kec) {
//     $.ajax({
//         type: "GET",
//         url: "https://x.rajaapi.com/MeP7c5ne23EtRlULiNs4VmgNCpkdLrpWFUN1L2TuiOaKlpabWj40eX0cLb/m/wilayah/kelurahan/",
//         data: { idkecamatan: id },
//         success: function (kel) {
//             // console.log(kel.data);
//             $.each(kel.data, function (k, v) {
//                 insert(kec, v.name);
//             });
//         }
//     });
// }
// function insert(kec, desa) {
//     token = $('input:hidden').val();
//     // console.log(kec, desa);
//     // console.log(token);
//     $.ajax({
//         method : "POST",
//         url : "http://127.0.0.1:8000/ongkirs",
//         data : { _token : token, kec : kec, desa : desa },
//         success : function (data) {
//             console.log(data);
//         }
//     });
// }
        setTimeout(function(){
            $('.alert').fadeOut();
        }, 3000);
        $('.custom-file-input').change(function(){
            let nama = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(nama);
        });
        $('.custom-select').change(function(){
            let jumlah = $(this).val();
            let harga = $(this).data('harga');
            let total = harga * jumlah;
            if(jumlah > 0){
                $('#jumlah-rp').html("Rp. "+number_format(total));
            }
        });
        $('#jml').keyup(function(){
            let jumlah = $(this).val();
            let stok = $(this).data('stok');
            let harga = $(this).data('harga');
            let total;
            if(jumlah > 0){
                if(jumlah <= stok){
                    total = harga * jumlah;
                }else{
                    total = 0;
                }
            }
            $('#jumlah-rp').html("Rp. "+number_format(total));
        });
    </script>
    @yield('script')
</body>
</html>