@extends('layout.main')

@section('content')
<div class="col-lg-12">

    <div class="card">
        {{-- HEADER --}}
        <div class="card-header">
            <h3 class="card-title">
                <i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
            </h3>
        </div>

        <div class="card-body">

            {{-- INFO BOX --}}
            <div class="row">

                {{-- TOTAL BARANG --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $totalBarang }}</h3>
                            <p>Total Barang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                    </div>
                </div>

                {{-- STOK MENIPIS --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stokMenipis }}</h3>
                            <p>Stok Menipis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>

                {{-- TOTAL PEMBELIAN --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalPembelian,0,',','.') }}</h3>
                            <p>Total Pembelian</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                    </div>
                </div>

                {{-- INPUT PEMBELIAN --}}
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Pembelian</h3>
                            <p>Input Barang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-plus-circle"></i>
                        </div>
                        <a href="{{ route('gudang.pembelian') }}" class="small-box-footer">
                            Tambah <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- GRAFIK PEMBELIAN --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Grafik Pembelian Tahun {{ date('Y') }}
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="chartGudang" height="120"></canvas>
                </div>
            </div>

            {{-- BARANG STOK MENIPIS --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-box-open"></i> Barang Stok Menipis
                    </h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($barangMenipis as $item)
                                <tr>
                                    <td>{{ $item->kode_barang }}</td>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>
                                        <span class="badge badge-danger">
                                            {{ $item->stok }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
                                        Semua stok aman
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('chartGudang');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulan) !!},
            datasets: [{
                label: 'Total Pembelian',
                data: {!! json_encode($total) !!},
                backgroundColor: 'rgba(255, 193, 7, 0.7)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID')
                                .format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID')
                                .format(value);
                        }
                    }
                }
            }
        }
    });

});
</script>
@endpush
