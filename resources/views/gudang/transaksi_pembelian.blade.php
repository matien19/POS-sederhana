@extends('layout.main')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
            <i class="fas fa-file-invoice"></i> Transaksi Pembelian
        </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pembelian.store') }}" method="POST">
                @csrf

                {{-- HIDDEN WAJIB --}}
                <input type="hidden" name="id_transaksi" value="{{ $transaksi->id }}">

                {{-- HEADER INFO --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>No. Pembelian</label>
                        <input type="text" class="form-control"
                               value="{{ $transaksi->no_transaksi }}" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Petugas</label>
                        <input type="text" class="form-control"
                               value="-" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal</label>
                        <input type="text" class="form-control"
                               value="{{ $tanggal->format('d-m-Y') }}" readonly>
                    </div>

                    <div class="col-md-3 text-end">
                        <label>Total</label>
                        <h4 id="grandTotal"><strong>Rp 0,-</strong></h4>
                    </div>
                </div>

                {{-- PILIH BARANG --}}
                <div class="mb-3">
                    <label>Masukan SKU</label>
                    <select id="barang" class="form-control">
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->id }}"
                                data-kode="{{ $item->kode_barang }}"
                                data-nama="{{ $item->nama_barang }}"
                                data-stok="{{ $item->stok }}"
                                data-harga="{{ $item->harga_beli }}">
                                {{ $item->kode_barang }} - {{ $item->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- DETAIL --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Nama Barang</label>
                        <div id="nama_barang_box" class="form-control"></div>
                    </div>

                    <div class="col-md-2">
                        <label>Sisa Stok</label>
                        <input type="text" id="stok" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <label>Harga Satuan</label>
                        <input type="text" id="harga" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <label>Jumlah Beli</label>
                        <input type="number" id="jumlah_beli" class="form-control" min="1">
                    </div>

                    <div class="col-md-3">
                        <label>Total Pembayaran</label>
                        <input type="text" id="total_bayar" class="form-control" readonly>
                    </div>
                </div>

                <button type="button" id="btnTambah" class="btn btn-success w-100 mb-4">
                    <i class="fas fa-cart-plus"></i> Tambah
                </button>

                {{-- SUPPLIER (FIXED) --}}
                <div class="mb-4">
                    <label>Supplier</label>
                    <select name="id_supplier" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($supplier as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- TABEL --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah Beli</th>
                            <th>Total Bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="listBarang">
                        <tr>
                            <td colspan="7" class="text-center text-muted">
                                Tidak ada data barang
                            </td>
                        </tr>
                    </tbody>
                </table>

                {{-- HIDDEN BARANG --}}
                <div id="inputHidden"></div>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-5">
                        Simpan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let no = 1;
let grandTotal = 0;

const stok = document.getElementById('stok');
const harga = document.getElementById('harga');
const jumlah_beli = document.getElementById('jumlah_beli');
const total_bayar = document.getElementById('total_bayar');
const listBarang = document.getElementById('listBarang');
const inputHidden = document.getElementById('inputHidden');
const nama_barang_box = document.getElementById('nama_barang_box');
const grandTotalEl = document.getElementById('grandTotal');

/* pilih barang */
document.getElementById('barang').addEventListener('change', function () {
    let opt = this.options[this.selectedIndex];
    if (!opt.value) return;

    stok.value = opt.dataset.stok;
    harga.value = opt.dataset.harga;
    nama_barang_box.innerHTML = opt.dataset.nama;
    jumlah_beli.value = '';
    total_bayar.value = '';
});

/* hitung total pembayaran */
jumlah_beli.addEventListener('input', function () {
    let qty = parseInt(this.value) || 0;
    let hargaVal = parseInt(harga.value) || 0;
    total_bayar.value = qty * hargaVal;
});

/* tambah ke tabel */
document.getElementById('btnTambah').addEventListener('click', function () {
    let barang = document.getElementById('barang');
    let opt = barang.options[barang.selectedIndex];
    let qty = parseInt(jumlah_beli.value);

    if (!opt.value || !qty) return alert('Data belum lengkap');

    let hargaVal = parseInt(opt.dataset.harga);
    let subtotal = qty * hargaVal;

    if (listBarang.innerText.includes('Tidak ada')) {
        listBarang.innerHTML = '';
    }

    listBarang.insertAdjacentHTML('beforeend', `
        <tr id="row-${no}">
            <td>${no}</td>
            <td>${opt.dataset.kode}</td>
            <td>${opt.dataset.nama}</td>
            <td>${hargaVal}</td>
            <td>${qty}</td>
            <td>${subtotal}</td>
            <td>
                <button type="button" class="btn btn-danger btn-sm"
                    onclick="hapus(${no}, ${subtotal})">
                    <i class="fas fa-trash"></i> hapus
                </button>
            </td>
        </tr>
    `);

    inputHidden.insertAdjacentHTML('beforeend', `
        <input type="hidden" name="barang[${no}][id]" value="${opt.value}">
        <input type="hidden" name="barang[${no}][qty]" value="${qty}">
        <input type="hidden" name="barang[${no}][harga]" value="${hargaVal}">
    `);

    grandTotal += subtotal;
    grandTotalEl.innerHTML = '<strong>Rp ' + grandTotal.toLocaleString('id-ID') + '</strong>';

    no++;
    jumlah_beli.value = '';
    total_bayar.value = '';
});

/* hapus barang */
function hapus(id, subtotal) {
    document.getElementById('row-' + id).remove();
    grandTotal -= subtotal;
    grandTotalEl.innerHTML = '<strong>Rp ' + grandTotal.toLocaleString('id-ID') + '</strong>';
}
</script>
@endpush