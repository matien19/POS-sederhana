@extends('layout.main')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-alt"></i> Laporan Penjualan
            </h3>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('laporan.penjualan') }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Awal</label>
                            <input type="date" name="tanggal_awal" class="form-control"
                                value="{{ request('tanggal_awal') }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Akhir</label>
                            <input type="date" name="tanggal_akhir" class="form-control"
                                value="{{ request('tanggal_akhir') }}">
                        </div>
                        {{-- <div class="form-group">
                            <label>Kasir</label>
                            <select name="id_user" class="form-control">
                                <option value="">-- Semua Kasir --</option>
                                @foreach ($petugas as $p)
                                <option value="{{ $p->id }}" {{ request('id_user')==$p->id ? 'selected' : '' }}>
                                    {{ $p->name }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}

                        {{-- <div class="form-group">
                            <label>Metode Pembayaran</label>
                            <select name="pembayaran" class="form-control">
                                <option value="">-- Semua Pembayaran --</option>
                                <option value="Cash" {{ request('pembayaran')=='Cash' ?'selected':'' }}>Cash</option>
                                <option value="Transfer" {{ request('pembayaran')=='Transfer' ?'selected':'' }}>Transfer
                                </option>
                                <option value="QRIS" {{ request('pembayaran')=='QRIS' ?'selected':'' }}>QRIS</option>
                                <option value="Debit" {{ request('pembayaran')=='Debit' ?'selected':'' }}>Debit</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <button type="submit" class="btn btn-info btn-sm mr-2">
                            <i class="fas fa-search"></i> Terapkan
                        </button>

                        <a href="{{ route('laporan.penjualan') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <hr>

            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nota</th>
                        <th>Tanggal</th>
                        <th>Kustomer</th>
                        <th>Total</th>
                        <th>Dibayar</th>
                        <th>Hutang</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->no_transaksi }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
                        <td>{{ $row->customer ?? '-' }}</td>
                        <td>
                            Rp {{ number_format($row->total_bayar,0,',','.') }}
                        </td>
                        <td>
                            Rp {{ number_format($row->pembayaran_sum_jumlah_bayar ?? 0,0,',','.') }}
                        </td>

                        <td>
                            Rp {{ number_format(
                            $row->total_bayar - ($row->pembayaran_sum_jumlah_bayar ?? 0),
                            0,',','.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Data tidak ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right mt-3">
                <a href="{{ route('laporan.penjualan.pdf', request()->query()) }}" target="_blank"
                    class="btn btn-danger btn-sm mr-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>

                {{-- <a href="{{ route('laporan.penjualan.excel', request()->query()) }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a> --}}
            </div>

        </div>
    </div>
</div>
@endsection