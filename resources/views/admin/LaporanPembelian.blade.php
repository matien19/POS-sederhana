@extends('layout.main')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-title">
                    <i class="fas fa-file-alt"></i> Laporan Pembelian
                </h3>
            </div>
        </div>

        <div class="card-body">

            <form action="{{ route('laporan.pembelian') }}" method="GET">
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
                            <label>Supplier</label>
                            <select name="id_supplier" class="form-control">
                                <option value="">-- Semua Supplier --</option>
                                @foreach ($supplier as $item)
                                <option value="{{ $item->id }}" {{ request('id_supplier')==$item->id ? 'selected' : ''
                                    }}>
                                    {{ $item->nama }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}

                        {{-- <div class="form-group">
                            <label>Petugas Gudang</label>
                            <select name="id_user" class="form-control">
                                <option value="">-- Semua Petugas --</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('id_user')==$user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                                @endforeach
                            </select>
                        </div> --}}
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-info btn-sm mr-2">
                        <i class="fas fa-search"></i> Terapkan
                    </button>

                    <a href="{{ route('laporan.pembelian') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-sync-alt"></i> Reset
                    </a>
                </div>
            </form>

            <hr>


            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No Pembelian</th>
                        <th>Tanggal</th>
                        <th>Supplier</th>
                        {{-- <th>Petugas</th> --}}
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->no_transaksi }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->tanggal)) }}</td>
                        <td>{{ optional($row->supplier)->nama ?? '-' }}</td>
                        {{-- <td>{{ optional($row->petugas)->name ?? '-' }}</td> --}}
                        <td>
                            Rp {{ number_format($row->total_bayar,0,',','.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data tidak ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-right mt-3">
                <a href="{{ route('laporan.pembelian.pdf', request()->query()) }}" target="_blank"
                    class="btn btn-danger btn-sm mr-2">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>

                {{-- <a href="{{ route('laporan.pembelian.excel', request()->query()) }}"
                    class="btn btn-success btn-sm">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a> --}}
            </div>
            {{-- ================= END BUTTON EXPORT ================= --}}

        </div>
    </div>
</div>
@endsection