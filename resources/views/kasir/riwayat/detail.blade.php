@extends('layout.main')
@section('content')

<div class="col-lg-12">

<div class="card">

<div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title">
        <i class="fas fa-file-invoice"></i> Detail Transaksi
    </h3>
</div>

<div class="card-body">
     <a href="{{ route('kasir.transaksi') }}" class="btn btn-secondary">
        <i class="fa fa-arrow-left"></i> Kembali
    </a>

    <div class="row mb-3">
        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th>No Transaksi</th>
                    <td>: {{ $transaksi->no_transaksi }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>:
                        {{ date('d-m-Y', strtotime($transaksi->tanggal)) }}
                        <small class="text-muted">[{{ date('H:i', strtotime($transaksi->tanggal)) }}]</small>
                    </td>
                </tr>
                <tr>
                    <th>Kasir</th>
                    <td>: {{ $transaksi->kasir->name ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="col-md-6">
            <table class="table table-borderless">
                <tr>
                    <th>Total Qty</th>
                    <td>: {{ $transaksi->total_qty }}</td>
                </tr>
                <tr>
                    <th>Total Bayar</th>
                    <td>: Rp {{ number_format($transaksi->total_bayar,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Metode</th>
                    <td>: {{ $transaksi->metode_bayar }}</td>
                </tr>
            </table>
        </div>
    </div>

    <hr>

    <h5>Barang yang Dibeli</h5>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach($detail as $i => $d)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $d->barang->nama_barang }}</td>
                <td>Rp {{ number_format($d->harga_satuan,0,',','.') }}</td>
                <td>{{ $d->jumlah_jual }}</td>
                <td>Rp {{ number_format($d->subtotal,0,',','.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
</div>

</div>

@endsection
