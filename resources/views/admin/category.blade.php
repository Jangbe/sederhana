@extends('layout.sb-admin')
@section('1-2', 'active')
@section('content')
@error('nama')
    <div class="alert alert-danger">Nama kategory harus diisi</div>
@enderror
@error('slug')
    <div class="alert alert-danger">Nama slug harus diisi</div>
@enderror
<button class="btn btn-success mb-3" data-toggle="modal" data-target="#modal" id="tambah">Tambah Kategori</button>


<table class="table table-striped">
    <tr class="bg-success text-white">
        <th>Nama Kategori</th>
        <th>Slug</th>
        <th>Detail</th>
        <th>Opsi</th>
    </tr>
    @foreach ($data as $category)
        <tr>
            <td>{{$category->nama_kategori}} </td>
            <td>{{$category->slug}} </td>
            <td>{{$category->detail}} </td>
            <td><button class="btn btn-primary" data-toggle="modal" data-id="{{ $category->id}}" id="edit" data-target="#modal">Edit</button>
             <button type="button" class="btn btn-danger" data-id="{{ $category->id}}" id="btn-hapus" data-toggle="modal" data-target="#hapus">Hapus</button></td>
        </tr>
    @endforeach
</table>

{{-- Modal untuk menghapus kategori --}}
<div class="modal fade" id="hapus">
    <div class="modal-dialog" role="dialog">
        <div class="modal-content">
            <form action="{{ url('admin/category/hapus')}}" method="POST">
                @csrf
                <input type="hidden" name="id" id="id_hapus" value="0">
                <div class="modal-body">
                    <h5>Apakah yakin anda ingin menghapus kategori ini?</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-danger" type="submit">Yakin</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal untuk menambah/mengubah kategori --}}
<div class="modal fade" id="modal">
    <div class="modal-dialog" role="dialog">
        <div class="modal-content">
            <form action="{{ url('admin/category') }}" method="post">
                <input type="hidden" name="id" id="id_kategori" value="0">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="title">Tambah Kategori</h5>
                    <button class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="nama">Nama Kategori</label>
                            <div class="input-group">
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="slug">Slug Kategori</label>
                            <div class="input-group">
                                <input type="text" name="slug" id="slug" class="form-control">
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="jml">Detail</label>
                            <input type="number" name="jml" id="jml" min="1" value="1" class="form-control">
                        </div>
                        <div class="jml col-12">
                            <div class="form-group">
                                <input type="text" name="detail[]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-success" type="submit">Tambahkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        $('button#edit').click(function(){
            var id = $(this).data('id');
            $('#title').html('Edit Kategori');
            $('form').attr('action', "{{ url('admin/category/edit')}}").attr('method', 'post');
            $.ajax({
                url: "{{url('admin/category/edit')}}",
                method: 'get',
                data: {id: id},
                success: function(data){
                    var result = JSON.parse(data);
                    $('#nama').val(result.nama_kategori);
                    $('#slug').val(result.slug);
                    $('input#id_kategori').val(id);
                }
            });
        });
        $('#tambah').click(function(){
            $('input#id_kategori').val(0);
            $('#nama').val('');
            $('#slug').val('');
            $('#title').html('Tambah Kategori');
            $('form').attr('action', "{{ url('admin/category')}}").attr('method', 'post');
        });
        $('button#btn-hapus').click(function(){
            var id = $(this).data('id');
            $('#id_hapus').val(id);
        });
        var asal = $('#jml').val();
        for (let a = 1; a < asal; a++) {
            $('.jml').append('<div class="form-group"><input type="text" name="detail[]" class="form-control"></div>');
        }
        $('#jml').change(function(){
            var jml = $(this).val();
            console.log(jml);
            if(asal < jml){
                for (let a = asal; a < jml; a++) {
                    $('.jml').append('<div class="form-group"><input type="text" name="detail[]" class="form-control"></div>');
                }
                console.log('ditambah');
            }else if(asal > jml && jml >= 1){
                for (let i = jml; i < asal; i++) {
                    $('.jml').children('div').last().remove();
                }
                console.log('dikurang');
            }else{
                for (let o = 1; o < asal; o++) {
                    $('.jml').children('div').last().remove();
                }
                $('#jml').val(1);
                jml = 1;
            }
            asal = jml;
        });
    </script>
@endsection
