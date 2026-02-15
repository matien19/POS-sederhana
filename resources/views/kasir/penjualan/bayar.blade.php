@extends('layout.main')

@section('title', 'Pembayaran Penjualan')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-cash-register"></i> Pembayaran Penjualan
        </h5>
        <span class="badge badge-primary">
            No. Nota : {{ $nota }}
        </span>
    </div>

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf

        <input type="hidden" name="no_transaksi" value="{{ $nota }}">

        <div class="card-body p-0">
            <div class="row no-gutters">

                {{-- ================= KIRI : TABEL BARANG ================= --}}
                <div class="col-lg-9 p-3">

                    <table class="table table-bordered table-striped text-center mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Noo</th>
                                <th>Nama Barang</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>

                        @php
                            $subTotal = 0;
                            // total qty semua item
                            $total_qty = 0;
                        @endphp

                        @forelse ($cart as $i => $item)

                            @php
                                $subTotal += $item['total'];
                                // tambahkan qty per item
                                $total_qty += $item['qty'];
                            @endphp

                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td>{{ $item['nama'] }}</td>
                                <td>{{ $item['qty'] }}</td>
                                <td>{{ number_format($item['harga']) }}</td>
                                <td>{{ number_format($item['total']) }}</td>
                            </tr>

                            {{-- kirim detail ke POST --}}
                            <input type="hidden" name="items[{{ $i }}][kode]" value="{{ $item['kode'] }}">
                            <input type="hidden" name="items[{{ $i }}][nama]" value="{{ $item['nama'] }}">
                            <input type="hidden" name="items[{{ $i }}][harga]" value="{{ $item['harga'] }}">
                            <input type="hidden" name="items[{{ $i }}][qty]" value="{{ $item['qty'] }}">
                            <input type="hidden" name="items[{{ $i }}][total]" value="{{ $item['total'] }}">

                        @empty
                            <tr>
                                <td colspan="5">Tidak ada data</td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>

                </div>

                {{-- ================= KANAN : FORM PEMBAYARAN ================= --}}
                <div class="col-lg-3 border-left bg-light p-3">

                    <div class="form-group">
                        <label>Kustomer</label>
                        <input type="text" name="kustomer" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Sub Total</label>
                        <input type="text" id="subTotal"
                               class="form-control text-right"
                               value="{{ $subTotal }}"
                               readonly>
                    </div>

                    <div class="form-group">
                        <label>Diskon (Rp)</label>
                        <input type="number"
                               name="diskon"
                               id="diskon"
                               class="form-control text-right"
                               value="0">
                    </div>

                    <div class="form-group">
                        <label>Total Bayar</label>
                        <input type="text"
                               name="total_bayar"
                               id="totalBayar"
                               class="form-control text-right font-weight-bold"
                               value="{{ $subTotal }}"
                               readonly>
                    </div>

                    {{-- <div class="form-group">
                        <label>Jumlah Bayar</label>
                        <input type="number"
                               name="jumlah_bayar"
                               id="jumlahBayar"
                               class="form-control text-right"
                               required>
                    </div> --}}

                    {{-- <div class="form-group">
                        <label>Kembali</label>
                        <input type="text"
                               name="kembalian"
                               id="kembalian"
                               class="form-control text-right"
                               readonly>
                    </div> --}}

                    <div class="form-group">
                        <label>Metode Bayar</label>
                        <select name="metode_bayar" class="form-control" required>
                            <option value="Cash">Cash</option>
                          
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan"
                                  class="form-control"
                                  rows="2"></textarea>
                    </div>

                    {{-- total qty dikirim ke server --}}
                    <input type="hidden" name="total_qty" value="{{ $total_qty }}">

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('penjualan.tambah') }}" class="btn btn-danger btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const subTotal    = document.getElementById('subTotal');
    const diskon      = document.getElementById('diskon');
    const totalBayar  = document.getElementById('totalBayar');
    const jumlahBayar = document.getElementById('jumlahBayar');
    const kembalian   = document.getElementById('kembalian');

    function hitungTotal() {
        let st = parseInt(subTotal.value) || 0;
        let dk = parseInt(diskon.value) || 0;
        let total = st - dk;
        totalBayar.value = total > 0 ? total : 0;
        hitungKembali();
    }

    function hitungKembali() {
        let bayar = parseInt(jumlahBayar.value) || 0;
        let total = parseInt(totalBayar.value) || 0;
        kembalian.value = bayar >= total ? bayar - total : 0;
    }

    diskon.addEventListener('input', hitungTotal);
    jumlahBayar.addEventListener('input', hitungKembali);
});
</script>

@endsection
