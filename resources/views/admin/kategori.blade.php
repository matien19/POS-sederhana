@extends('layout.main')
@section('content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title">
              <h3 class="card-title">
            <i class="fas fa-chart-pie"></i> Data Kategori
        </h3>
            </div>
        </div>
        <div class="card-body">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
            <table id="example1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kategori</th>
                        <th><center> Aksi</center></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_kategori as $item)
                            <tr>
                                <td>{{ $loop->iteration}}</td>
                                <td>{{ $item->nama_kategori}}</td>
                                <td>
                                <center>
                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" data-id="{{ $item->id}}" data-nama="{{ $item->nama_kategori}}"><i class="fas fa-edit"></i> edit</button>
                                <button type="button" class="btn btn-danger btn-sm btn-hapus" data-url="{{ url('kategori/destroy/'.$item->id) }}"><i class="fas fa-trash"></i> Hapus</button>
                                </center>
                                </td>
                            </tr>
                        @endforeach
                    </tbody> 
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fas fa-chart-pie"></i>
                  Data Kategori</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('kategori.add')}}" method="POST">
                @csrf
            <div class="modal-body">
              <div class="form-group">
                    <label for="nama_kategori">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="Masukkan Nama Kategori" >
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
            <h4 class="modal-title"><i class="fas fa-chart-pie"></i>
              Edit Data Kategori</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="POST" id="form-edit">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" id="nama_kategori" placeholder="Masukkan nama kategori" required>
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
      var id = $(e.relatedTarget).data('id');
      var nama_kategori = $(e.relatedTarget).data('nama');
      var url = 'kategori/update/'+id;

      $(e.currentTarget).find('input[name="nama_kategori"]').val(nama_kategori);;
      $('#form-edit').attr('action', url);
    })
  </script>

@endpush