@extends('layout.main')
@section('content')

<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-receipt"></i> Riwayat Transaksi
        </h3>
    </div>

    <div class="card-body">

        <table id="example1" class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nota</th>
                    <th>Kasir</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th><center>Aksi</center></th>
                </tr>
            </thead>

            <tbody>
                @foreach ($transaksi as $row)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ date('d-m-Y', strtotime($row->tanggal)) }}
                        <small class="text-muted">[{{ date('H:i', strtotime($row->tanggal)) }}]</small>
                    </td>
                    <td>{{ $row->no_transaksi }}</td>
                    <td>{{ $row->kasir->name ?? '-' }}</td>
                    <td>Rp {{ number_format($row->total_bayar,0,',','.') }}</td>
                    <td>{{ $row->metode_bayar }}</td>
                    <td>
                        <center>
                        <a href="{{ route('kasir.transaksi.show',$row->id) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-info-circle"></i> Detail
                        </a>
                        <a href="{{ route('kasir.transaksi.struk',$row->id) }}"
                        target="_blank"
                        class="btn btn-primary btn-sm">
                        <i class="fa fa-print"></i> Cetak Struk
                        </a>
                        <button type="button" class="btn btn-danger btn-sm btn-hapus" data-url="{{ url('kasir/transaksi/destroy/'.$row->id) }}"><i class="fas fa-trash"></i> Hapus</button>
                        </center>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>

        <small class="text-danger">
            <i class="fa fa-info-circle"></i> Hapus akan mengembalikan stok ke admin dan menghapus transaksi.
        </small>

    </div>
</div>
</div>

@endsection
