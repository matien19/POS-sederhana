@extends('layout.main')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="nav-icon fas fa-tachometer-alt"></i> Dashboard
            </h3>
        </div>
        <div class="card-body">

            <div class="row">

                <!-- Total Barang -->
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

                <!-- Stok Habis -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $stokHabis }}</h3>
                            <p>Stok Habis</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Penjualan -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalPenjualan,0,',','.') }}</h3>
                            <p>Total Penjualan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-cash-register"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Pembelian -->
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalPembelian,0,',','.') }}</h3>
                            <p>Total Pembelian</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                    </div>
                </div>

            </div>
            {{-- GRAFIK --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Grafik Penjualan & Pembelian ({{ date('Y') }})
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="chartTransaksi" height="120"></canvas>
                </div>
            </div>
            <!-- Transaksi Terbaru -->
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i> Transaksi Terbaru
                    </h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No Transaksi</th>
                                <th>Jenis</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksiTerbaru as $item)
                                <tr>
                                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $item->no_transaksi }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->jenis_transaksi == 'penjualan' ? 'success' : 'warning' }}">
                                            {{ ucfirst($item->jenis_transaksi) }}
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($item->total_bayar,0,',','.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Belum ada transaksi
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
    const ctx = document.getElementById('chartTransaksi').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(
                $grafik->pluck('bulan')->map(fn($b) => date('F', mktime(0,0,0,$b,1)))
            ) !!},
            datasets: [
                {
                    label: 'Penjualan',
                    data: {!! json_encode($grafik->pluck('penjualan')) !!},
                    backgroundColor: 'rgba(40, 167, 69, 0.6)',
                    borderRadius: 8
                },
                {
                    label: 'Pembelian',
                    data: {!! json_encode($grafik->pluck('pembelian')) !!},
                    backgroundColor: 'rgba(255, 193, 7, 0.6)',
                    borderRadius: 8
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        boxWidth: 15
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': Rp ' +
                                new Intl.NumberFormat('id-ID').format(context.raw);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
                    }
                }
            }
        }
    });
</script>
@endpush