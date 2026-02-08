@extends('layout.main')

@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
            <i class="fas fa-edit"></i> Edit Transaksi Pembelian
        </h3>
            <a href="{{ route('admin.pembelian') }}" class="btn btn-secondary btn-sm float-right">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pembelian.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- INFO --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>No. Pembelian</label>
                        <input type="text" class="form-control" value="{{ $transaksi->no_transaksi }}" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Petugas</label>
                        <input type="text" class="form-control" value="{{ $users->name }}" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal</label>
                        <input type="text" class="form-control" value="{{ $tanggal->tanggal }}" readonly>
                    </div>

                    <div class="col-md-3 text-end">
                        <label>Total</label>
                        <h4 id="grandTotal">
                            <strong>Rp {{ number_format($transaksi->total_bayar) }}</strong>
                        </h4>
                    </div>
                </div>

                {{-- PILIH BARANG --}}
                <div class="mb-3">
                    <label>Pilih Barang</label>
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

                {{-- INPUT BARANG --}}
                <div class="row mb-3">
                    <div class="col-md-3">
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

                    <div class="col-md-2">
                        <label>Jumlah Beli</label>
                        <input type="number" id="qty" class="form-control" min="1">
                    </div>

                    <div class="col-md-3">
                        <label>Total Pembayaran</label>
                        <input type="text" id="total" class="form-control" readonly>
                    </div>
                </div>

                <button type="button" id="btnTambah" class="btn btn-success w-100 mb-4">
                    <i class="fas fa-cart-plus"></i> Tambah
                </button>

                {{-- SUPPLIER --}}
                <div class="mb-4">
                    <label>Supplier</label>
                    <select name="id_supplier" class="form-control" required>
                        <option value="">-- Pilih Supplier --</option>
                        @foreach ($supplier as $item)
                            <option value="{{ $item->id }}"
                                {{ old('id_supplier', $transaksi->id_supplier) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TABEL DETAIL --}}
                <table class="table table-bordered">
                    <thead class="text-center">
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
                        @foreach ($pembelian->detail as $i => $item)
                        <tr id="row-{{ $i }}">
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $item->barang->kode_barang }}</td>
                            <td>{{ $item->barang->nama_barang }}</td>
                            <td>Rp {{ number_format($item->harga_satuan) }}</td>
                            <td>{{ $item->jumlah_beli }}</td>
                            <td>Rp {{ number_format($item->subtotal) }}</td>
                            <td class="text-center">
                                <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="hapusRow({{ $i }}, {{ $item->subtotal }})"><i class="fas fa-trash"></i> Hapus</button>
                            </td>

                            {{-- hidden agar data lama ikut --}}
                            <input type="hidden" name="barang[{{ $i }}][id]" value="{{ $item->id_barang }}">
                            <input type="hidden" name="barang[{{ $i }}][qty]" value="{{ $item->jumlah_beli }}">
                            <input type="hidden" name="barang[{{ $i }}][harga]" value="{{ $item->harga_satuan }}">
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <button type="submit" class="btn btn-primary px-5">Simpan</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let no = {{ $pembelian->detail->count() }};
let grandTotal = {{ $transaksi->total_bayar }};

barang.onchange = function () {
    let o = this.options[this.selectedIndex];
    if (!o.value) return;
    nama_barang.value = o.dataset.nama;
    stok.value = o.dataset.stok;
    harga.value = o.dataset.harga;
    qty.value = '';
    total.value = '';
};

qty.oninput = function () {
    total.value = harga.value && qty.value
        ? 'Rp ' + (harga.value * qty.value).toLocaleString()
        : '';
};

btnTambah.onclick = function () {
    let o = barang.options[barang.selectedIndex];
    if (!o.value || qty.value <= 0) return alert('Lengkapi data');

    let totalHarga = o.dataset.harga * qty.value;
    grandTotal += totalHarga;

    listBarang.insertAdjacentHTML('beforeend', `
        <tr id="row-${no}">
            <td>${no + 1}</td>
            <td>${o.dataset.kode}</td>
            <td>${o.dataset.nama}</td>
            <td>Rp ${Number(o.dataset.harga).toLocaleString()}</td>
            <td>${qty.value}</td>
            <td>Rp ${totalHarga.toLocaleString()}</td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm"
                    onclick="hapusRow(${no}, ${totalHarga})">❌</button>
            </td>

            <input type="hidden" name="barang[${no}][id]" value="${o.value}">
            <input type="hidden" name="barang[${no}][qty]" value="${qty.value}">
            <input type="hidden" name="barang[${no}][harga]" value="${o.dataset.harga}">
        </tr>
    `);

    grandTotalEl();
    barang.value = qty.value = nama_barang.value = stok.value = harga.value = total.value = '';
    no++;
};

function hapusRow(id, total) {
    document.getElementById('row-' + id).remove();
    grandTotal -= total;
    grandTotalEl();
}

function grandTotalEl() {
    document.getElementById('grandTotal').innerHTML =
        `<strong>Rp ${grandTotal.toLocaleString()}</strong>`;
}
</script>
@endpush