@extends('layout.main')

@section('title','Edit Transaksi Penjualan')

@section('content')
<div class="col-lg-12">
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-edit"></i> Edit Transaksi Penjualan
            </h3>
            <a href="{{ route('admin.penjualan.index') }}"
               class="btn btn-secondary btn-sm float-right">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <form method="POST"
                  action="{{ route('admin.penjualan.update',$transaksi->id) }}"
                  id="formSimpan">
                @csrf
                @method('PUT')

                {{-- INFO TRANSAKSI --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>No Nota</label>
                        <input type="text" class="form-control"
                               value="{{ $transaksi->no_transaksi }}" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Kasir</label>
                        <input type="text" class="form-control"
                               value="{{ optional($transaksi->kasir)->name ?? '-' }}" readonly>
                    </div>

                    <div class="col-md-3">
                        <label>Tanggal</label>
                        <input type="text" class="form-control"
                               value="{{ $transaksi->tanggal }}" readonly>
                    </div>

                    <div class="col-md-3 text-end">
                        <label>Total</label>
                        <h4 id="grandTotal">
                            <strong>Rp {{ number_format($transaksi->total_bayar,0,',','.') }}</strong>
                        </h4>
                    </div>
                </div>

                {{-- PILIH BARANG --}}
                <div class="mb-3">
                    <label>Pilih Barang</label>
                    <select id="pilihBarang" class="form-control">
                        <option value="">-- Pilih Barang --</option>
                        @foreach ($barang as $b)
                            <option value="{{ $b->id }}"
                                data-kode="{{ $b->kode_barang }}"
                                data-nama="{{ $b->nama_barang }}"
                                data-harga="{{ $b->harga_jual }}"
                                data-stok="{{ $b->stok }}">
                                {{ $b->kode_barang }} - {{ $b->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- INPUT BARANG --}}
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Nama Barang</label>
                        <input id="nama" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <label>Sisa Stok</label>
                        <input id="stok" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <label>Harga Satuan</label>
                        <input id="harga" class="form-control" readonly>
                    </div>

                    <div class="col-md-2">
                        <label>Jumlah Jual</label>
                        <input id="qty" type="number" class="form-control" min="1">
                    </div>

                    <div class="col-md-3">
                        <label>Subtotal</label>
                        <input id="subtotal" class="form-control" readonly>
                    </div>
                </div>

                <button type="button" id="btnTambah"
                        class="btn btn-success w-100 mb-4">
                    <i class="fas fa-cart-plus"></i> Tambah
                </button>

                {{-- TABEL DETAIL --}}
                <table class="table table-bordered table-striped text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tabel"></tbody>
                </table>

                <input type="hidden" name="items" id="items">

                <div class="text-end mt-3">
                    <button class="btn btn-primary px-5"> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
let grandTotal = 0;

/* DATA AWAL */
@foreach ($transaksi->penjualan as $p)
cart.push({
    kode: "{{ $p->barang->kode_barang }}",
    nama: "{{ $p->barang->nama_barang }}",
    harga: {{ $p->harga_satuan }},
    qty: {{ $p->jumlah_jual }},
    subtotal: {{ $p->subtotal }}
});
@endforeach

const pilih = document.getElementById('pilihBarang');
const nama  = document.getElementById('nama');
const stok  = document.getElementById('stok');
const harga = document.getElementById('harga');
const qty   = document.getElementById('qty');
const sub   = document.getElementById('subtotal');
const tabel = document.getElementById('tabel');
const grand = document.getElementById('grandTotal');

function render() {
    tabel.innerHTML = '';
    grandTotal = 0;

    cart.forEach((i, idx) => {
        grandTotal += i.subtotal;
        tabel.insertAdjacentHTML('beforeend', `
            <tr>
                <td>${idx + 1}</td>
                <td>${i.kode}</td>
                <td>${i.nama}</td>
                <td>Rp ${i.harga.toLocaleString()}</td>
                <td>${i.qty}</td>
                <td>Rp ${i.subtotal.toLocaleString()}</td>
                <td>
                    <button type="button"
                        class="btn btn-danger btn-sm"
                        onclick="hapus(${idx})">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
        `);
    });

    grand.innerHTML = `<strong>Rp ${grandTotal.toLocaleString()}</strong>`;
}

function hapus(i) {
    cart.splice(i, 1);
    render();
}

pilih.onchange = () => {
    let o = pilih.options[pilih.selectedIndex];
    if (!o.value) return;

    nama.value  = o.dataset.nama;
    stok.value  = o.dataset.stok;
    harga.value = o.dataset.harga;
    qty.value   = 1;
    sub.value   = o.dataset.harga;
};

qty.oninput = () => {
    if (parseInt(qty.value) > parseInt(stok.value)) {
        alert('Jumlah melebihi stok!');
        qty.value = stok.value;
    }

    sub.value = harga.value && qty.value
        ? harga.value * qty.value
        : '';
};

btnTambah.onclick = () => {
    if (!pilih.value || qty.value <= 0)
        return alert('Lengkapi data barang');

    cart.push({
        kode: pilih.options[pilih.selectedIndex].dataset.kode,
        nama: nama.value,
        harga: parseInt(harga.value),
        qty: parseInt(qty.value),
        subtotal: parseInt(sub.value)
    });

    pilih.value = nama.value = stok.value = harga.value = qty.value = sub.value = '';
    render();
};

formSimpan.onsubmit = () => {
    items.value = JSON.stringify(cart);
};

render();
</script>
@endpush
