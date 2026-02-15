@extends('layout.main')

@section('title','Detail Transaksi Penjualan')

@section('content')
<div class="col-lg-12">

    {{-- HEADER TRANSAKSI --}}
    <div class="card mb-3">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-file-invoice"></i> Detail Transaksi Penjualan
            </h3>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary btn-sm float-right">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Nama Kustomer</th>
                            <td>: {{ $transaksi->customer ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>: {{ $transaksi->tanggal }}</td>
                        </tr>
                        <tr>
                            <th>No Pembelian</th>
                            <td>: {{ $transaksi->no_transaksi }}</td>
                        </tr>
                        <tr>
                            <th>Status Pembayaran</th>
                            <td>:
                                @if ($transaksi->status_pembayaran == 'BELUM_LUNAS')
                                <span class="badge badge-danger">Hutang</span>
                                @else
                                <span class="badge badge-success">Lunas</span>
                                @endif

                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="table table-borderless">
                        <tr>
                            <th width="200">Total</th>
                            <td>: Rp {{ number_format($total) ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Diskon</th>
                            <td>: Rp {{ number_format($transaksi->diskon) ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Total Pembayaran</th>
                            <td>: <strong>Rp {{ number_format($transaksi->total_bayar) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Sisa Hutang</th>
                            <td>: <strong>Rp {{ number_format(($sisa = $transaksi->total_bayar - $total_dibayar))
                                    }}</strong>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL DETAIL BARANG --}}
    <div class="card">
        <div class="card-header">
            <h5>Daftar Barang</h5>
        </div>

        <div class="card-body p-0">
            <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah Jual</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi->penjualan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($item->barang)->nama_barang ?? '-' }}</td>
                        <td>Rp {{ number_format($item->harga_satuan,0,',','.') }}</td>
                        <td>{{ $item->jumlah_jual }}</td>
                        <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Tidak ada detail barang
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Pembayaran</h5>
        </div>

        <div class="card-body p-0">
            <button type="button" class="btn btn-primary btn-sm m-2" data-toggle="modal" data-target="#modal-tambah">
                Tambah Pembayaran
            </button>
            <table id="example1" class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Tanggal Bayar</th>
                        <th>Jumlah Bayar</th>
                        <th>
                            <center>
                                aksi
                            </center>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pembayaran as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tanggal_bayar ?? '-' }}</td>
                        <td class="text-right">Rp {{ number_format($item->jumlah_bayar ?? 0 ,0,',','.' ) }}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#modal-edit" data-id="{{ $item->id }}" data-bayar="{{ $item->jumlah_bayar }}">
                                Edit
                            </button>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr class="bg-secondary">
                        <td colspan="2"> Total </td>
                        <td class="text-right">Rp {{number_format($total_dibayar ??  0 ,0,',','.' )}} </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</div>

<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Pembayaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('penjualan.pembayaran.add', $transaksi->id)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <h6 for="sisa hutang" class="text-info">Sisa Hutang : Rp {{$sisa}} </h6>

                    <input type="hidden" name="sisa" value="{{$sisa}}">
                    <div class="form-group">
                        <label for="nama_kategori">bayar</label>
                        <input type="number" name="bayar" class="form-control" id="bayar" required>
                    </div>

                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" name="btn_tambah_kategori" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"> Pembayaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" id="form-edit">
                @csrf
                <div class="modal-body">
                    <h6 for="sisa hutang" class="text-info">Sisa Hutang : Rp {{$sisa}} </h6>
                    <input type="hidden" name="sisa" value="{{$sisa}}">
                    <div class="form-group">
                        <label for="nama_kategori">bayar</label>
                        <input type="number" name="bayar" class="form-control" id="bayar" required>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="submit" name="btn_edit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@push('scripts')
<script type="text/javascript">
    $('#modal-edit').on('show.bs.modal', function(e) {
      var id = {{$transaksi->id}}
      var id_bayar = $(e.relatedTarget).data('id');
      var bayar = $(e.relatedTarget).data('bayar');
      var url = '/penjualan/pembayaran/'+id+'/'+id_bayar;

      $(e.currentTarget).find('input[name="bayar"]').val(bayar);;
      $('#form-edit').attr('action', url);
    })
</script>

@endpush