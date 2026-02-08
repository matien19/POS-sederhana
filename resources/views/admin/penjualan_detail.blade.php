@extends('layout.main')

@section('title','Detail Transaksi Penjualan')

@section('content')
<div class="col-lg-12">

    {{-- HEADER TRANSAKSI --}}
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-invoice"></i> Detail Transaksi Penjualan
            </h3>
            <a href="{{ route('admin.penjualan.index') }}"
               class="btn btn-secondary btn-sm float-right">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <table class="table table-borderless">
                <tr>
                    <th width="200">Nama Kasir</th>
                    <td>: {{ optional($transaksi->kasir)->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>: {{ $transaksi->tanggal }}</td>
                </tr>
                <tr>
                    <th>No Nota</th>
                    <td>: {{ $transaksi->no_transaksi }}</td>
                </tr>
                <tr>
                    <th>Total Pembayaran</th>
                    <td>
                        : <strong>Rp {{ number_format($transaksi->total_bayar,0,',','.') }}</strong>
                    </td>
                </tr>
                <tr>
                    <th>Pembayaran</th>
                    <td>
                        : {{ ucfirst($transaksi->metode_bayar ?? '-') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- TABEL DETAIL BARANG --}}
    <div class="card">
        <div class="card-header">
            <h5>Daftar Barang</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah Jual</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi->penjualan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ optional($item->barang)->nama_barang ?? '-' }}</td>
                            <td>Rp {{ number_format($item->harga_satuan,0,',','.') }}</td>
                            <td>{{ $item->jumlah_jual }}</td>
                            <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada detail barang
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
