@extends('layout.sb-admin')
@section('2', 'active')
@section('p-1', 'active')
@section('title', 'Tambah Produk')
@section('content')
<div class="row">
    <div class="col-md-4 mb-3">
        <img src="{{ url('img/barang/default.jpg') }}" class="img-thumbnail d-block w-100">
    </div>
    <div class="col-md-8">
        <form action="{{ url('produk/add') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="nama">Nama Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="text" class="form-control" name="nama" value="{{old('nama')}}" placeholder="Nama barang.." id="nama">
                </div>
                @error('nama')
                    <span class="text-danger ml-2">Nama barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="singkatan">Singkatan Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="text" class="form-control" name="singkatan" value="{{old('singkatan')}}" placeholder="Max 11 huruf.." maxlength="11" id="singkatan">
                </div>
                @error('singkatan')
                    <span class="text-danger ml-2">Nama barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row berat">
                <label class="col-5 col-md-3 col-form-label" for="berat">Berat Barang</label>
                <div class="input-group col-7 col-md-9">
                    <input type="text" class="form-control" name="berat" value="{{old('berat')}}" placeholder="Berat barang.." id="berat">
                </div>
                @error('berat')
                    <span class="text-danger ml-2">Berat barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row harga">
                <label class="col-5 col-md-3 col-form-label" for="harga">Harga Barang</label>
                <div class="input-group col-7 col-md-9">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Rp</span>
                    </div>
                    <input type="number" class="form-control" name="harga" value="{{old('harga')}}" placeholder="Harga barang.." id="harga">
                </div>
                @error('harga')
                    <span class="text-danger ml-2">Harga barang harus di isi.</span>
                @enderror
            </div>
            <div class="form-group row gambar">
                <label class="col-5 col-md-3 col-form-label" for="gambar">Gambar Barang</label>
                <div class="input-group col-7 col-md-9">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" value="{{old('gambar')}}" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Pilih gambar..</label>
                    </div>
                </div>
                @error('gambar')
                    <span class="text-danger ml-2">Gambar barang harus di pilih.</span>
                @enderror
            </div>
            <div class="form-group row">
                <label class="col-5 col-md-3 col-form-label" for="kategori">Kategori Barang</label>
                <div class="input-group col-7 col-md-9">
                    <select name="kategori" class="custom-select" id="kategori">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $menu)
                        <option value="{{$menu->slug}}">{{$menu->nama_kategori}} </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="kategori">

            </div>
            <div class="form-group">
                <div class="input-group">
                    <button class="btn btn-primary col-12">Tambah Barang</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('script')
    <script>
        var default_kat = $('#kategori').val();
        kategori(default_kat);
        $('#kategori').change(function(){
            var data = $(this).val();
            $('.kategori').empty();
            kategori(data);
        });
        function kategori(data){
            if(data != ''){
                $.ajax({
                    url: "{{ url('admin/getdetail')}}",
                    method: 'get',
                    data: {slug: data},
                    success: function(data){
                        var result = JSON.parse(data);
                        var detail = result.detail.split('-');
                        for (let i = 1; i < detail.length; i++) {
                            $('.kategori').append('<div class="form-group row stok"><label class="col-5 col-md-3 col-form-label" for="kode">Satu '+detail[i-1]+' berisi</label><div class="input-group col-md-9 col-7"><input type="number" class="form-control" min="0" name="detail[]" placeholder="... '+detail[i]+'" id="bks"></div></div>');
                        }
                    }
                });
            }
        }
    </script>
@endsection
