@extends('layout.main')
@section('content')
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i> Transaksi Pembelian
        </h3>
    </div>

    <div class="card-body">

        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Pembelian</th>
                    <th>Supplier</th>
                    <th>Total</th>
                    <th><center>Aksi</center></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelian as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->no_transaksi }}</td>

                    {{-- ✅ FIX --}}
                    <td>{{ $item->supplier->nama ?? '-' }}</td>
                    <td>{{ number_format($item->total_bayar ?? 0) }}</td>

                    <td>
                        <center>
                        {{-- <a href="{{ route('admin.pembelian.show', $item->id) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <a href="{{ route('admin.pembelian.edit', $item->id) }}"
                        class="btn btn-success btn-sm">
                        <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button"
                            class="btn btn-danger btn-sm btn-hapus"
                            data-url="{{ url('admin/pembelian/destroy/'.$item->id) }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button> --}}
                        </center>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
</div>
@endsection