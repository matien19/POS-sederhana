@extends('layout.main');
@section('content')
<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-title">
            <i class="fas fa-truck"></i> Data Supplier
        </h3>
        </div>
    </div>
    <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
                  <thead>
                  <tr>
                    <th><center>No</center></th>
                    <th>Nama Supplier</th>
                    <th>Nomor Telepon</th>
                    <th>Tanggal Daftar</th>
                    <th>Alamat</th>
                    <th><center>Aksi</center></th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($supplier as $item)
                    <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->no_telepon }}</td>
                    <td>{{ $item->tanggal_daftar }}</td>
                    <td>{{ $item->alamat }}</td>
                    <td>
                        <center>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}" data-no_telepon="{{ $item->no_telepon }}" data-tanggal_daftar="{{ $item->tanggal_daftar }}" data-alamat="{{ $item->alamat }}"><i class="fas fa-edit"> </i> Edit</button>             
                        <button type="button"
                          class="btn btn-danger btn-sm btn-hapus"
                          data-url="{{ url('supplier/destroy/'.$item->id) }}">
                          <i class="fas fa-trash"></i> Hapus
                        </button>
                        </center>

                    </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                
                <div class="modal fade" id="modal-tambah">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-truck"> Tambah Data Supplier</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="{{ route('supplier.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nama"> Nama Supplier </label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Supplier">
                                </div>
                                <div class="form-group">
                                    <label for="no_telepon"> Nomor Telepon </label>
                                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Masukkan Nomor Telepon">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_daftar"> Tanggal Daftar </label>
                                    <input type ="date" name="tanggal_daftar" class="form-control" id="tanggal_daftar" placeholder="Masukkan Tanggal Daftar">
                                </div>
                                <div class="form-group">
                                    <label for="alamat"> Alamat </label>
                                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat">
                                </div>
                            </div>
                        <div class="modal-footer justify-content-end">
                        <button type="submit" name="btn_tambah" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->

                <div class="modal fade" id="modal-edit">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title"><i class="fas fa-truck"> Edit Data Supplier</i></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <form action="" method="POST" id="form-edit">
                        @csrf
                            <div class="modal-body">    
                                <div class="form-group">
                                    <label for="nama"> Nama Supplier</label>
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama Supplier" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="no_telepon"> Nomor Telepon</label>
                                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Masukkan Nomor Telepon">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_daftar"> Tanggal Daftar </label>
                                    <input type="date" name="tanggal_daftar" class="form-control" id="tanggal_daftar" placeholder="Masukkan Tanggal Daftar">
                                </div>
                                <div class="form-group">
                                    <label for="alamat"> Alamat </label>
                                    <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat">
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
                <!-- /.modal -->
    </div>
</div>
</div>
    
@endsection
@push('scripts')
<script type="text/javascript"> 
  $('#modal-edit').on('show.bs.modal', function(e){
    var id = $(e.relatedTarget).data('id');
    var nama = $(e.relatedTarget).data('nama');
    var no_telepon = $(e.relatedTarget).data('no_telepon');
    var tanggal_daftar = $(e.relatedTarget).data('tanggal_daftar');
    var alamat = $(e.relatedTarget).data('alamat');
    var url = 'supplier/update/'+id;
    
    $(e.currentTarget).find('input[name="nama"]').val(nama);
    $(e.currentTarget).find('input[name="no_telepon"]').val(no_telepon);
    $(e.currentTarget).find('input[name="tanggal_daftar"]').val(tanggal_daftar);
    $(e.currentTarget).find('input[name="alamat"]').val(alamat);
    $('#form-edit').attr('action', '/supplier/update/' + id);
  })
</script>
@endpush