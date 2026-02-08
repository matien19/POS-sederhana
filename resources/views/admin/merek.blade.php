@extends('layout.main')
@section('content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-title">
                        <i class="fas fa-box"></i> Merek Barang
                    </h3>
                </div>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i
                        class="fas fa-plus"></i> Tambah Data</button>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Merek Barang</th>
                            <th>
                                <center>Aksi</center>
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data_merek as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama_merek }}</td>
                                <td>
                                    <center>
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal"
                                            data-target="#modal-edit" data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama_merek }}"><i class="fas fa-edit"> Edit</i>
                                        </button>

                                        <button type="button" class="btn btn-danger btn-sm btn-hapus"
                                            data-url="{{ url('merek/destroy/' . $item->id) }}">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </center>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-user mr-1"></i>
                        Edit Merek Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" id="form-edit">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_merek">Nama Merek</label>
                            <input type="text" name="nama_merek" class="form-control" id="nama_merek"
                                placeholder="Masukkan nama merek" required>
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

    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><i class="fas fa-door-closed"></i>
                        Tambah Merek Barang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('merek.add') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama_merek">Nama Merek</label>
                            <input type="text" name="nama_merek" class="form-control" id="nama_merek"
                                placeholder="Masukkan Nama Merek">
                        </div>

                    </div>
                    <div class="modal-footer justify-content-end">
                        <button type="submit" name="btn_tambah" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        @endsection
        @push('scripts')
            <script type="text/javascript">
                $('#modal-edit').on('show.bs.modal', function(e) {
                    var id = $(e.relatedTarget).data('id');
                    var nama_merek = $(e.relatedTarget).data('nama');
                    var url = 'merek/update/' + id;

                    $(e.currentTarget).find('input[name="nama_merek"]').val(nama_merek);
                    $('#form-edit').attr('action', 'merek/update/' + id);

                })
            </script>
        @endpush
