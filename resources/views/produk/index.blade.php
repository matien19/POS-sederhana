@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <table width="100%">
                <tr>
                    <td>
                        <h4>
                            Data Produk
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
                            <h3 class="card-title">Daftar Produk</h3>
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
                                        <th>Kategori</th>
                                        <th>Nama Produk</th>
                                        <th>Stok</th>
                                        <th>Harga</th>
                                        <th>Foto</th>
                                        <th>
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $produk)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $produk->kategori->nama_kategori }}</td>
                                            <td>{{ $produk->nama_produk }}</td>
                                            <td>{{ $produk->stok_produk }}</td>
                                            <td class="text-right"> Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</td>
                                            <td>
                                                <center>
                                                    @if ($produk->gambar_produk)
                                                        <img src="{{ asset('uploads/produk/' . $produk->gambar_produk) }}"
                                                            alt="Gambar Produk" width="50">
                                                    @else
                                                        Tidak ada gambar
                                                    @endif
                                                </center>
                                            </td>
                                            <td>
                                                <center>
                                                    <button type="button" class="btn btn-outline-info btn-sm"
                                                        data-toggle="modal" data-target="#modal-default"
                                                        data-kode="{{ $produk->id }}"
                                                        data-nama="{{ $produk->nama_produk }}"
                                                        data-kategori="{{ $produk->kategori_id }}"
                                                        data-stok="{{ $produk->stok_produk }}"
                                                        data-harga="{{ $produk->harga_produk }}"
                                                        data-deskripsi="{{ $produk->deskripsi_produk }}"
                                                        >
                                                        <i class="nav-icon fas fa-edit"></i>
                                                    </button>

                                                    <button type="button" class="btn btn-outline-danger btn-sm btn-hapus"
                                                        data-kode="{{ $produk->id }}">
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
        <div class="modal-dialog modal-lg">
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
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="kategori_id">Kategori</label>
                                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                                        <option value="" selected disabled>-- Pilih Kategori --</option>
                                        @foreach ($kategori as $kat)
                                            <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback" id="error-kategori_id"></div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_produk">Nama Produk</label>
                                    <input type="text" class="form-control" name="nama_produk" id="nama_produk"
                                        placeholder="Masukan Nama Produk" required>
                                    <div class="invalid-feedback" id="error-nama_produk"></div>
                                </div>
                                <div class="form-group">
                                    <label for="stok_produk">Stok</label>
                                    <input type="number" class="form-control" name="stok_produk" id="stok_produk"
                                        placeholder="Masukan Stok Produk" required>
                                    <div class="invalid-feedback" id="error-stok_produk"></div>
                                </div>
                                <div class="form-group">
                                    <label for="harga_produk">Harga</label>
                                    <input type="number" class="form-control" name="harga_produk" id="harga_produk"
                                        placeholder="Masukan Harga Produk" required>
                                    <div class="invalid-feedback" id="error-harga_produk"></div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="deskripsi_produk">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi_produk" id="deskripsi_produk" rows="4"
                                        placeholder="Masukan Deskripsi Produk"></textarea>
                                    <div class="invalid-feedback" id="error-deskripsi_produk"></div>
                                </div>
                                <div class="form-group">
                                    <label for="gambar_produk">Gambar Produk</label>
                                    <input type="file" class="form-control" name="gambar_produk" id="gambar_produk"
                                        accept="image/*">
                                    <div class="invalid-feedback" id="error-gambar_produk"></div>
                                </div>
                            </div>
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
                var id = button.data('kode');
                var kategori = button.data('kategori');
                var nama = button.data('nama');
                var stok = button.data('stok');
                var harga = button.data('harga');

                if (id) {
                    $('.modal-title').text('Edit Produk');
                    $('#kategori_id').val(kategori);
                    $('#nama_produk').val(nama);
                    $('#stok_produk').val(stok);
                    $('#harga_produk').val(harga);
                    $('#deskripsi_produk').val(button.data('deskripsi'));
                    $('#form-tambah-data').data('edit', true);
                    $('#form-tambah-data').data('kode', id);
                } else {
                    $('.modal-title').text('Tambah Produk');
                    $('#kategori_id').val('');
                    $('#nama_produk').val('');
                    $('#stok_produk').val('');
                    $('#harga_produk').val('');
                    $('#deskripsi_produk').val('');
                    $('#gambar_produk').val('');
                    $('#kode_produk').attr('readonly', false);
                    $('#form-tambah-data').data('edit', false);
                    $('#form-tambah-data').data('kode', null);
                }
            });

            $('#form-tambah-data').on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const isEdit = $(this).data('edit');
                const id = $(this).data('kode');

                const url = isEdit ?
                    '/produk/update/' + id :
                    "{{ route('produk.store') }}";

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
                var kode_produk = button.data('kode');
                var url = "{{ route('produk.destroy', ':id') }}".replace(':id', kode_produk);
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
