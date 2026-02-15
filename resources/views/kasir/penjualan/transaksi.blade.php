@extends('layout.main')

@section('title', 'Transaksi Penjualan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-shopping-cart"></i>
            Transaksi Penjualan
        </h3>
    </div>

    <div class="card-body">

        {{-- Header --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Scan Barcode</label>
                <input type="text" class="form-control" placeholder="Scan barcode">
            </div>

            <div class="col-md-3">
                <label>Kasir</label>
                <input type="text" class="form-control" value="Kasir" readonly>
            </div>

            <div class="col-md-3">
                <label>No. Nota</label>
                <input type="text" class="form-control" value="{{ $noNota }}" readonly>
            </div>

            <div class="col-md-3 text-right">
                <label>Total</label>
                <h3 class="font-weight-bold mb-0" id="grandTotal">Rp 0</h3>
            </div>
        </div>

        {{-- Pilih Produk --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>Pilih Produk</label>
                <select class="form-control" id="pilihBarang">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($barang as $item)
                        <option
                            value="{{ $item->id }}"
                            data-kode="{{ $item->kode_barang }}"
                            data-nama="{{ $item->nama_barang }}"
                            data-stok="{{ $item->stok }}"
                            data-harga="{{ $item->harga_jual }}"
                        >
                            {{ $item->kode_barang }} - {{ $item->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="row mb-3">
            <div class="col-md-2">
                <label>Nama Barang</label>
                <input type="text" id="nama_barang" class="form-control" readonly>
            </div>

            <div class="col-md-2">
                <label>Sisa Stok</label>
                <input type="text" id="stok" class="form-control" readonly>
            </div>

            <div class="col-md-2">
                <label>Harga Satuan</label>
                <input type="text" id="harga" class="form-control" readonly>
            </div>

            <div class="col-md-3">
                <label>Jumlah Jual</label>
                <input type="number" id="qty" class="form-control" min="1">
            </div>

            <div class="col-md-3">
                <label>Total Pembayaran</label>
                <input type="text" id="total" class="form-control" readonly>
            </div>
        </div>

        {{-- TOMBOL TAMBAH (TIDAK SUBMIT) --}}
        <button type="button" id="btnTambah" class="btn btn-success btn-block mb-4">
            <i class="fas fa-cart-plus"></i> Tambah
        </button>

        {{-- Tabel Transaksi --}}
        <h6 class="font-weight-bold">Data Transaksi</h6>
        <table class="table table-bordered table-striped text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Jual</th>
                    <th>Total Bayar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="tabelTransaksi">
                <tr id="kosong">
                    <td colspan="7">Belum ada data</td>
                </tr>
            </tbody>
        </table>

        {{-- BAYAR --}}
        <a href="{{ route('penjualan.bayar') }}"
            class="btn btn-primary">
                BAYAR
            </a>

    </div>
</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const token       = document.querySelector('meta[name="csrf-token"]').content;
    const pilihBarang = document.getElementById('pilihBarang');
    const namaBarang  = document.getElementById('nama_barang');
    const stokInput   = document.getElementById('stok');
    const hargaInput  = document.getElementById('harga');
    const qtyInput    = document.getElementById('qty');
    const totalInput  = document.getElementById('total');
    const btnTambah   = document.getElementById('btnTambah');
    const tabel       = document.getElementById('tabelTransaksi');
    const grandTotal  = document.getElementById('grandTotal');
    const inputGrandTotal = document.getElementById('inputGrandTotal');

    let no = 1;
    let totalAll = 0;

    pilihBarang.addEventListener('change', function () {
        const s = this.options[this.selectedIndex];
        if (!s.value) return;

        namaBarang.value = s.dataset.nama;
        stokInput.value  = s.dataset.stok;
        hargaInput.value = s.dataset.harga;
        qtyInput.value   = 1;
        hitung();
    });

    qtyInput.addEventListener('input', hitung);

    function hitung() {
        totalInput.value = (hargaInput.value * qtyInput.value) || 0;
    }

    btnTambah.addEventListener('click', function () {

        if (!pilihBarang.value || qtyInput.value <= 0) {
            alert('Lengkapi data barang');
            return;
        }

        const s = pilihBarang.options[pilihBarang.selectedIndex];
        const kode  = s.dataset.kode;
        const nama  = s.dataset.nama;
        const harga = parseInt(hargaInput.value);
        const qty   = parseInt(qtyInput.value);
        const total = harga * qty;

        fetch("{{ route('penjualan.addCart') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({ kode, nama, harga, qty })
        })
        .then(res => res.json())
        .then(res => {
            if (!res.success) return;

            document.getElementById('kosong')?.remove();

            tabel.insertAdjacentHTML('beforeend', `
                <tr>
                    <td>${no++}</td>
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td>${harga.toLocaleString()}</td>
                    <td>${qty}</td>
                    <td>${total.toLocaleString()}</td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                            onclick="hapusRow(this, ${total})">Hapus</button>
                    </td>
                </tr>
            `);

            totalAll += total;
            grandTotal.innerText = 'Rp ' + totalAll.toLocaleString();
            inputGrandTotal.value = totalAll;

            pilihBarang.value = '';
            namaBarang.value  = '';
            stokInput.value   = '';
            hargaInput.value  = '';
            qtyInput.value    = '';
            totalInput.value  = '';
        });
    });

   window.hapusRow = function(btn, total) {
    btn.closest('tr').remove();
    totalAll -= total;
    grandTotal.innerText = 'Rp ' + totalAll.toLocaleString();
    inputGrandTotal.value = totalAll;
};


});
</script>
@endsection
