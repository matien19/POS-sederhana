@extends('layout.main')

@section('content')
<div class="col-lg-12">

    {{-- HEADER --}}
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-invoice"></i> Detail Transaksi Pembelian
            </h3>
            <a href="{{ route('pembelian') }}" class="btn btn-secondary btn-sm float-right">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>


        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama Supplier</th>
                            <td>: {{ $transaksi->supplier->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>: {{ $transaksi->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>No Pembelian</th>
                            <td>: {{ $transaksi->no_transaksi }}</td>
                        </tr>
                        <tr>
                            <th>Status Pembayaran</th>
                            <td>:
                                @if ($transaksi->status_pembayaran == 'BELUM_LUNAS')
                                    <span class="badge badge-danger">Hutang</span>
                                @else
                                    <span class="badge badge-success">Lunas</span>
                                @endif

                                -  Dibayar tanggal : {{ $pembayaran->tanggal_bayar ?? '-'}}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Total</th>
                            <td>: Rp {{ number_format($total) ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diskon</th>
                            <td>: Rp {{ number_format($transaksi->diskon) ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Total Pembayaran</th>
                            <td>: <strong>Rp {{ number_format($transaksi->total_bayar) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>

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
                        <th>Jumlah Beli</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi->detail as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga_satuan) }}</td>
                        <td>{{ $item->jumlah_beli }}</td>
                        <td>Rp {{ number_format($item->subtotal) }}</td>
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