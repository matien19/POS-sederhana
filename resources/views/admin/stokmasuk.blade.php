@extends('layout.main')

@section('content')

<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-download"></i> Barang Masuk
        </h3>
    </div>

    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Masuk</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($barangMasuk as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->transaksi->supplier->nama ?? '-' }}</td>
                    <td>{{ $item->barang->kode_barang }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ $item->jumlah_beli }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>
</div>

@endsection
