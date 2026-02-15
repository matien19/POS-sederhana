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
                        <th>Status</th>
                        <th>
                            <center>Aksi</center>
                        </th>
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
                            @if ($item->status_pembayaran == 'BELUM_LUNAS')
                            <span class="badge badge-danger">Hutang</span>
                            @else
                            <span class="badge badge-success">Lunas</span>
                            @endif
                        </td>

                        <td>
                            <center>
                                @if ($item->status_pembayaran == 'BELUM_LUNAS')
                                <button type="button" class="btn btn-warning btn-sm btn-lunaskan"
                                    data-url="{{ route('pembelian.lunaskan', $item->id) }}">
                                    <i class="fas fa-check-circle"></i> Lunaskan
                                </button>
                                @endif
                                <a href="{{ route('detail_pembelian.show', $item->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-info-circle"></i> Detail
                                </a>
                                {{-- <a href="{{ route('detail_pembelian.update', $item->id) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a> --}}
                                <button type="button" class="btn btn-danger btn-sm btn-hapus"
                                    data-url="{{ url('pembelian/destroy/'.$item->id) }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>

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
@push('scripts')
<script>
document.addEventListener('click', function(e) {

    if (e.target.closest('.btn-lunaskan')) {

        let btn = e.target.closest('.btn-lunaskan');
        let url = btn.dataset.url;

        if (confirm('Yakin ingin melunaskan pembayaran ini?')) {
            window.location.href = url;
        }
    }

});
</script>
@endpush
