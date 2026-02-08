@extends('layout.main')

@section('content')
<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">

                {{-- HEADER --}}
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-info-circle mr-1"></i> Detail Barang
                    </h3>
                </div>

                {{-- BODY --}}
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-12">
                            <a href="{{ route('barang') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="row">

                        {{-- FOTO + BARCODE --}}
                        <div class="col-md-4 text-center mb-3">
                            <img
                                src="{{ $barang->foto_barang
                                    ? Storage::url('img/'.$barang->foto_barang) : asset('storage/img/barang_default.jpeg') }}"
                                class="img-fluid img-thumbnail mb-3"
                                style="max-height: 280px"
                                alt="Foto Barang">

                            <img
                                src="{{ asset('storage/barcode/'.strtolower($barang->kode_barang).'.png') }}"
                                class="img-fluid"
                                style="width:200px; height:50px;">

                            <div class="mt-1 font-weight-bold">
                                {{ $barang->kode_barang }}
                            </div>
                        </div>

                        {{-- DETAIL --}}
                        <div class="col-md-8">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th width="35%">Kode Barang</th>
                                        <td>{{ $barang->kode_barang }}</td>
                                    </tr>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <td>{{ $barang->nama_barang }}</td>
                                    </tr>
                                    <tr>
                                        <th>Kategori</th>
                                        <td>{{ $barang->kategori->nama_kategori ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Merek</th>
                                        <td>{{ $barang->merek->nama_merek ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Stok</th>
                                        <td>{{ $barang->stok }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga Beli</th>
                                        <td>Rp {{ number_format($barang->harga_beli,0,',','.') }}</td>
                                    </tr>
                                    <tr>
                                        <th>Harga Jual</th>
                                        <td>Rp {{ number_format($barang->harga_jual,0,',','.') }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- 🔽 BUTTON AREA (SEPERTI DATA BARANG) --}}
                            <div class="mt-3">
                                <a href="{{ route('barang.barcode', $barang->id) }}"
                                   target="_blank"
                                   class="btn btn-success btn-sm ml-1">
                                    <i class="fas fa-barcode"></i> Cetak Barcode
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="card-footer text-muted text-right">
                    <small>
                        Terakhir diperbarui:
                        {{ $barang->updated_at?->format('d M Y H:i') ?? '-' }}
                    </small>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
