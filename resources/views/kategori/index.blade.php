@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <table width="100%">
                <tr>
                    <td>
                        <h4>
                            Data Kategori
                        </h4>
                    </td>
                </tr>
            </table>

        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Main row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Kategori</h3>
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal"
                                data-target="#modal-default">
                                <i class="nav-icon fas fa-plus"></i> Tambah Data
                            </button>
                           
                            <br><br>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->nama_kategori }}</td>
                                            <td>
                                                <center>
                                                    <button type="button" class="btn btn-outline-warning btn-sm"
                                                        data-toggle="modal" data-target="#modal-default"
                                                        data-kode="{{ $item->id }}"
                                                        data-nama="{{ $item->nama_kategori }}">
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-hapus"
                                                        data-kode="{{ $item->id }}">
                                                        <i class="nav-icon fas fa-trash"></i>
                                                    </button>
                                                </center>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Tambah Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-tambah-data" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" class="form-control" name="nama_kategori" id="nama_kategori"
                                placeholder="Masukan Nama Kategori" required>
                            <div class="invalid-feedback" id="error-nama_kategori"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" id="simpan">Simpan</button>
                    </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
   
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#modal-default').on('show.bs.modal', function(event) {
                $(this).removeAttr('aria-hidden');

                var edit = false;
                var button = $(event.relatedTarget);
                var kode_kategori = button.data('kode');
                var nama = button.data('nama');

                if (kode_kategori) {
                    $('.modal-title').text('Edit Kategori');
                    $('#nama_kategori').val(nama);
                    $('#kode_kategori').val(kode_kategori);
                    $('#kode_kategori').attr('readonly', true);
                    $('#form-tambah-data').data('edit', true);
                    $('#form-tambah-data').data('kode', kode_kategori);
                } else {
                    $('.modal-title').text('Tambah Kategori');
                    $('#kode_kategori').val('');
                    $('#nama_kategori').val('');
                    $('#kode_kategori').attr('readonly', false);
                    $('#form-tambah-data').data('edit', false);
                    $('#form-tambah-data').data('kode', null);
                }
            });

            $('#form-tambah-data').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const isEdit = $(this).data('edit');
                const kodeLembaga = $(this).data('kode');

                const url = isEdit ?
                    '/kategori/update/' + kodeLembaga :
                    "{{ route('kategori.store') }}";

                const method = 'POST';

                // Clear previous error messages
                $('.invalid-feedback').text('').hide();
                $.ajax({
                    type: method,
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#simpan').attr('disabled', 'disabled');
                        $('#simpan').html(
                            '<i class="fa fa-spinner fa-spin mr-1"></i> Menyimpan');
                    },
                    complete: function() {
                        $('#simpan').removeAttr('disabled');
                        $('#simpan').html('Simpan');
                    },
                    success: function(response) {
                        if (response.status === 'warning') {
                            Toast.fire({
                                icon: 'warning',
                                title: response.message
                            });
                        } else {
                            $('#modal-default').modal('hide');
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            $('#form-tambah-data')[0].reset();
                            setTimeout(function() {
                                location.reload();
                            }, 2500);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            const errors = xhr.responseJSON.errors;

                            $.each(errors, function(key, value) {
                                let inputField = $('#' + key);
                                let errorFeedback = $('#error-' + key);

                                inputField.addClass(
                                    'is-invalid'); // Tambahkan class is-invalid
                                errorFeedback.text(value[0])
                                    .show(); // Tampilkan pesan error
                            });

                        } else if (xhr.responseJSON && xhr.responseJSON.error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: xhr.responseJSON.error
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Kesalahan tidak terduga. Silakan coba lagi.'
                            });
                        }
                    }
                });

            });

            $('.btn-hapus').on('click', function(e) {

                var button = $(this);
                var kode_kategori = button.data('kode');
                var url = "{{ route('kategori.destroy', ':id') }}".replace(':id', kode_kategori);
                var method = 'DELETE';

                Swal.fire({
                    title: "Hapus Data",
                    text: "Apakah Anda yakin ingin menghapus data?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            type: method,
                            url: url,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },

                            processData: false,
                            contentType: false,
                            beforeSend: function() {
                                button.attr('disabled', 'disabled');
                                button.html(
                                    '<i class="fa fa-spinner fa-spin mr-1"></i> Menghapus'
                                );
                            },
                            complete: function() {
                                button.removeAttr('disabled');
                                button.html(
                                    '<i class="nav-icon fas fa-trash"></i>');
                            },

                            success: function(response) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message
                                });
                                $('#form-tambah-data')[0].reset();
                                setTimeout(function() {
                                    location.reload();
                                }, 2500);
                            },
                            error: function(xhr) {
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    const errors = xhr.responseJSON.errors;

                                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: xhr.responseJSON.error
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: 'Kesalahan tidak terduga. Silakan coba lagi.'
                                    });
                                }
                            }
                        });

                    }
                });

            })

        });
    </script>
@endpush

