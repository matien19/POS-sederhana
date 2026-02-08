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

                {{-- TOTAL PENJUALAN HARI INI --}}
                <div class="col-lg-4 col-12">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>Rp {{ number_format($totalHariIni,0,',','.') }}</h3>
                            <p>Penjualan Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>

                {{-- JUMLAH TRANSAKSI --}}
                <div class="col-lg-4 col-12">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $jumlahTransaksi }}</h3>
                            <p>Transaksi Hari Ini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                    </div>
                </div>

                {{-- MULAI TRANSAKSI --}}
                <div class="col-lg-4 col-12">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>Kasir</h3>
                            <p>Mulai Penjualan</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <a href="{{ route('kasir.penjualan') }}" class="small-box-footer">
                            Mulai <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

            </div>
             {{-- GRAFIK PENJUALAN --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-bar"></i> Grafik Penjualan Tahun {{ date('Y') }}
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="chartKasir" height="120"></canvas>
                </div>
            </div>

            {{-- TRANSAKSI TERBARU --}}
            <div class="card mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i> Transaksi Terakhir
                    </h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No Transaksi</th>
                                <th>Total</th>
                                <th>Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transaksiTerbaru as $row)
                                <tr>
                                    <td>{{ date('d-m-Y H:i', strtotime($row->tanggal)) }}</td>
                                    <td>{{ $row->no_transaksi }}</td>
                                    <td>Rp {{ number_format($row->total_bayar,0,',','.') }}</td>
                                    <td>
                                        <span class="badge badge-primary">
                                            {{ strtoupper($row->metode_bayar) }}
                                        </span>
                                    </td>
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
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('chartKasir');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($bulan) !!},
            datasets: [{
                label: 'Total Penjualan',
                data: {!! json_encode($total) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.6)',
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
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
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

});
</script>
@endpush
