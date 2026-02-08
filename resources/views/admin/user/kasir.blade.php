@extends('layout.main')
@section('content')

<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-user"></i> Kelola Akun Kasir
        </h3>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Kasir</button>
        <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                        <th><center>Role</center></th>
                        <th><center>Nama</center></th>
                        <th><center>Email</center></th>
                        <th><center>Telepon</center></th>
                        <th><center>Aksi</center></th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><center>{{ ucfirst($item->posisi) }}</center></td>
                        <td><center>{{ $item->name }}</center></td>
                        <td><center>{{ $item->email }}</center></td>
                        <td><center>{{ $item->no_telepon ?? '-' }}</center></td>
                        <td>
                            <center>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-email="{{ $item->email }}" data-no_telepon="{{ $item->no_telepon }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-url="{{ url('admin/user/kasir/destroy/'.$item->id) }}"><i class="fas fa-trash"></i> Hapus</button>
                            </center>
                        </td>
                    </tr>
                    @endforeach
                  
                </table>
    </div>
</div>
</div>

<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fas fa-user mr-1"></i>
                  Tambah Kasir Baru</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('admin.user.kasir.add') }}" method="POST">
              @csrf
            <div class="modal-body">
            <input type="hidden" name="posisi" value="kasir">
              <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama kasir" >
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukkan email kasir" >
                  </div>
                  <div class="form-group">
                    <label for="no_telepon">Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Masukkan telepon kasir" >
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
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fas fa-user mr-1"></i>
                  Edit Data Kasir</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" id="form-edit">
              @csrf
            <div class="modal-body">
                  <input type="hidden" name="posisi" value="kasir">
                    <div class="form-group">
                    <label for="name">Nama</label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama kasir" >
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" placeholder="Masukkan email kasir" >
                  </div>
                  <div class="form-group">
                    <label for="no_telepon">Telepon</label>
                    <input type="text" name="no_telepon" class="form-control" id="no_telepon" placeholder="Masukkan telepon kasir" >
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
  $('#modal-edit').on('show.bs.modal', function(e){
    var id = $(e.relatedTarget).data('id');
    var name = $(e.relatedTarget).data('name');
    var email = $(e.relatedTarget).data('email');
    var no_telepon = $(e.relatedTarget).data('no_telepon');
    var url = '/admin/user/kasir/update/'+id;
    
    $(e.currentTarget).find('input[name="name"]').val(name);
    $(e.currentTarget).find('input[name="email"]').val(email);
    $(e.currentTarget).find('input[name="no_telepon"]').val(no_telepon);
    $('#form-edit').attr('action',url);
  })
</script>
@endpush