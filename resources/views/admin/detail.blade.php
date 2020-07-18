    @extends('layout.sb-admin')
    @section('1', 'active')
    @section('content')
    <div class="col-12 col-md-7">
        @if($data)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Detail Pembeli</h5>
                <table cellpadding="5" class="col-12">
                    <tr>
                        <td><b>Nama Pembeli</b></td>
                        <td>:</td>
                        <td>{{ $data->nama }}</td>
                    </tr>
                    <tr>
                        <td><b>Email Pembeli</b></td>
                        <td>:</td>
                        <td>{{ $data->email }}</td>
                    </tr>
                    <tr>
                        <td><b>Nomer WA Pembeli</b></td>
                        <td>:</td>
                        <td>{{ $data->telepon }}</td>
                    </tr>
                    <tr>
                        <td><b>Alamat Pembeli</b></td>
                        <td>:</td>
                        <td>{{ str_replace('-', ' - ', $data->alamat) }}</td>
                    </tr>
                    <tr>
                        <td><b>Catatan Pembeli</b></td>
                        <td>:</td>
                        <td>{{ $data->catatan }}</td>
                    </tr>
                </table>
            </div>
            @php
                $total = 0;
            @endphp
            <ul class="list-group list-group-flush">
                @foreach($barang as $brg)
                @php
                    $total += $brg->jml_harga;
                @endphp
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-7">
                            <b>{{$brg->jml_beli}}</b> {{$brg->nama }}
                        </div>
                        <div class="col-5 text-right">
                            {{ number_format($brg->jml_harga) }}
                        </div>
                    </div>
                </li>
                @endforeach
                <li class="list-group-item text-right">Rp. {{number_format($total)}} </li>
            </ul>
            <div class="card-body">
                <form action="{{ url('') }}" method="post">
                    <label for="pesan">Status:</label>
                    <select name="pesan" id="pesan" class="custom-select">
                        @for($i = 0; $i <= 4; $i++)
                        @if($data->kode_pesan == ($i + 1))
                        <option value="" selected>{{ $pesan[$i]->detail_pesan }} </option>
                        @else
                        <option value="">{{ $pesan[$i]->detail_pesan }} </option>
                        @endif
                        @endfor
                    </select>
                    <button type="submit" class="btn col-12 btn-success mt-3">Update keranjang</button>
                </form>
            </div>
        </div>
        @endif
    </div>
    @endsection
