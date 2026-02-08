@extends('layout.main')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-shopping-cart"></i> Transaksi Penjualan
            </h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nota</th>
                        <th>Kasir</th>
                        <th>Pembayaran</th>
                        <th>Total</th>
                        <th><center>Aksi</center></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi->where('jenis_transaksi','penjualan') as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->no_transaksi }}</td>
                            <td>{{ optional($item->kasir)->name ?? '-' }}</td>
                            <td>{{ ucfirst($item->metode_bayar ?? '-') }}</td>
                            <td>
                                Rp {{ number_format($item->total_bayar,0,',','.') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.penjualan.show',$item->id) }}"
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>

                                <a href="{{ route('admin.penjualan.edit',$item->id) }}"
                                   class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <button type="button"
                                    class="btn btn-danger btn-sm btn-hapus"
                                    data-url="{{ url('admin/penjualan/destroy/'.$item->id) }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
