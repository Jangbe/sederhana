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
                    <img src="{{ 'https://pkl1.4visionmedia.net/img/barang/'.$data->gambar }}" class="card-img border" style="width: 100%; height: 100%;">
                </div>
                <div class="col-md-7">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-6">
                            <h5 class="card-title">{{ $data->nama }}</h4>
                        </div>
                        <div class="col-6 col-md-6 text-right">
                            <span class="border h5 px-2 px-md-3 py-1 rounded bg-secondary text-white" id="jumlah-rp">Rp. {{ number_format($data->harga) }}</span>
                        </div>
                    </div>
                    <h6 class="card-title text-muted">[{{ $nama_kategori }}] Rp. {{ number_format($data->harga) }}</h6>
                    <p class="card-title text-muted">
                        Stok [{{ $stok_kata }}] Berat [{{ $data->berat }}] Kg
                    </p>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-5 col-6 col-form-label">Kode Barang</label>
                        <div class="col-sm-7 col-6">
                            <input type="text" class="form-control" name="kode_barang" id="inputEmail3" value="{{ $data->kode_barang }}" readonly>
                        </div>
                    </div>

                    @for($i = 0; $i < count($kategori); $i++)
                    <div class="form-group row">
                        <label for="1" class="col-sm-5 col-6 col-form-label">Beli per {{$kategori[$i]}}</label>
                        <div class="col-sm-7 col-6">
                            <input type="number" name="detail[]" class="form-control" data-detail="{{ $rincian[$i] }}" id="jml" min="0" max="{{ $stok[$i] }}" data-harga="{{ $data->harga }}" data-stok="{{ $data->stok }}" data-index="{{$i}}">
                        </div>
                    </div>
                    @endfor

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
@section('script')
<script>
    var total = 0;
    let asal = [0,0,0];
    $('input#jml').change(function(){
        let jumlah = $(this).val();
        let stok = $(this).data('stok');
        let harga = $(this).data('harga');
        let detail = $(this).data('detail');
        let index = $(this).data('index');
        let selisih;
        if(jumlah <= stok){
            if(asal[index] < jumlah){
                selisih = jumlah - asal[index];
                total += (detail * selisih);
            }else{
                if(jumlah != 0){
                    selisih = asal[index] - jumlah;
                }else{
                    selisih = 1;
                }
                total -= (detail * selisih);
            }
            asal[index] = jumlah;
        }else{
            total = 0;
        }
        // console.log(total);
        $('#jumlah-rp').html("Rp. "+number_format(total * harga));
    });
</script>
@endsection
