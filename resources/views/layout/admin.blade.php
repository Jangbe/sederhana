<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ url('css/app.css')}}">
    <link rel="stylesheet" href="{{ url('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ url('font/css/all.css')}}">
    <title>Sederhana | Admin</title>
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
                        <a href="{{ url('admin') }}" class="nav-link @yield('1')"><i class="fas fa-tachometer-alt"></i><span class="d-none d-md-inline"> Dashboard</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @yield('2')" data-toggle="dropdown" href="#" role="button" aria-expanded="false"><i class="fas fa-tablet"></i><span class="d-none d-md-inline"> Produk</span></a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item @yield('p-1')" href="{{ url('/produk/add')}}">Tambah Produk</a>
                            <a class="dropdown-item @yield('p-2')" href="{{ url('/produk/edit')}}">Edit Produk</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('profile') }}" class="nav-link @yield('3')"><i class="fas fa-user"></i><span class="d-none d-md-inline"> Profile</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/logout') }}"><i class="fas fa-sign-out-alt"></i><span class="d-none d-md-inline"> Logout</span></a>
                    </li>
                  </ul>
            </div>
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
    {{-- <script src="{{ url('js/ongkir.js')}}"></script> --}}
    <script>
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
</body>
</html>
