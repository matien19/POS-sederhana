@extends('layout.main')
@section('content')

<div class="col-lg-12">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-box"></i> Data Barang
        </h3>
    </div>
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus"></i> Tambah Data</button>
        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-import"><i class="fas fa-file-excel"></i>
                Import Data
              </button>
        <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Merek</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>
                      <center>Foto</center>
                    </th>
                    <th>
                      <center>Aksi</center>
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($data_barang as $item )
                    <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->kode_barang }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $item->merek->nama_merek ?? '-' }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>Rp {{ number_format($item->harga_beli,0,',','.') }}</td>
                    <td>Rp {{ number_format($item->harga_jual,0,',','.') }}</td>
                    <td>
                      <center>
                      <img src="{{ $item->foto_barang ? Storage::url('img/'.$item->foto_barang) : asset('storage/img/barang_default.jpeg') }}" class="img-fluid" style="width:100px"></img>
                      </center>
                    </td>
                    <td>
                      <center>
                        <a href="{{ url('barang/show/'.$item->id) }}" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i> Detail</a>
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-edit" data-id="{{ $item->id }}" data-kode="{{ $item->kode_barang }}" data-nama="{{ $item->nama_barang }}" data-kategori="{{ $item->id_kategori }}" data-merek="{{ $item->merek_id }}"data-stok="{{ $item->stok }}" data-harga_beli="{{ $item->harga_beli }}" data-harga_jual="{{ $item->harga_jual }}" data-foto="{{ $item->foto_barang }}"><i class="fas fa-edit"></i> edit</button>
                        <button type="button" class="btn btn-danger btn-sm btn-hapus" data-url="{{ url('barang/destroy/'.$item->id) }}"><i class="fas fa-trash"></i> Hapus</button>
                      </center>
                    </td>
                  </tr>
                    @endforeach
                  
                </table>
    </div>
</div>
</div>
<div class="modal fade" id="modal-tambah">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><i class="fas fa-box mr-1"></i>
                  Data Barang</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('barang.add') }}" method="POST" enctype="multipart/form-data">
              @csrf
            <div class="modal-body">
              <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" id="kode_barang" placeholder="Masukkan kode barang" >
                  </div>
                  <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" id="nama_barang" placeholder="Masukkan nama barang" >
                  </div>
                  <div class="form-group">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                          <option value="" disabled selected>-- Pilih Kategori --</option>
                          @foreach ($kategori as $item )
                          <option value="{{ $item->id }}">
                            {{ $item->nama_kategori }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Merek</label>
                        <select name="merek_id" class="form-control" required>
                          <option value="" disabled selected>-- Pilih Merek --</option>
                          @foreach ($merek as $item )
                          <option value="{{ $item->id }}">
                            {{ $item->nama_merek }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" class="form-control" id="stok" placeholder="Masukkan stok" >
                  </div>
                  <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" id="harga_beli" placeholder="Masukkan harga beli" >
                  </div>
                  <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual" placeholder="Masukkan harga jual" >
                  </div>
                  <div class="form-group">
                    <label for="foto_barang">Foto</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="form-control" id="foto_barang" name="foto_barang" accept="image.jpg, image/jpeg, image/png">
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
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
              <h4 class="modal-title"><i class="fas fa-box mr-1"></i>
                  Edit Data Barang</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST" id="form-edit" enctype="multipart/form-data">
              @csrf
            <div class="modal-body">
              <div class="form-group">
                    <label for="kode_barang">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" id="kode_barang" placeholder="Masukkan kode barang" readonly>
                  </div>
                  <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" id="nama_barang" placeholder="Masukkan nama barang" >
                  </div>
                  <div class="form-group">
                        <label>Kategori</label>
                        <select name="id_kategori" class="form-control" required>
                          <option value="" disabled selected>-- Pilih Kategori --</option>
                          @foreach ($kategori as $item )
                          <option value="{{ $item->id }}">
                            {{ $item->nama_kategori }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>Merek</label>
                        <select name="merek_id" class="form-control" required>
                          <option value="" disabled selected>-- Pilih Merek --</option>
                          @foreach ($merek as $item )
                          <option value="{{ $item->id }}">
                            {{ $item->nama_merek }}
                          </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" class="form-control" id="stok" placeholder="Masukkan stok" >
                  </div>
                  <div class="form-group">
                    <label for="harga_beli">Harga Beli</label>
                    <input type="number" name="harga_beli" class="form-control" id="harga_beli" placeholder="Masukkan harga beli" >
                  </div>
                  <div class="form-group">
                    <label for="harga_jual">Harga Jual</label>
                    <input type="number" name="harga_jual" class="form-control" id="harga_jual" placeholder="Masukkan harga jual" >
                  </div>
                  <center>
              <img src="" alt="" width="200px" height="200px" id="foto">
              </center>
                  <div class="form-group">
                    <label for="foto_barang">Foto</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="form-control" id="foto_barang" name="foto_barang" accept="image.jpg, image/jpeg, image/png">
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
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

      <div class="modal fade" id="modal-import">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><i class="fas fa-file-excel mr-1"></i>
              Import Data Barang</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('barang.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
              <div class="form-group">
                <label>Template Barang : </label>
                <a href="{{ asset('storage/template_import/template_data_barang.xls')}}" class="btn btn-info btn-xs"> Download</a>
              </div>
              <div class="form-group">
                <label for="import">Upload File</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="import" name="file_barang" accept=".xlsx,.xls" required>
                    <label class="custom-file-label" for="import">Pilih File</label>
                  </div>
                  <div class="input-group-append">
                    <span class="input-group-text">Upload</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-end">
              <button type="submit" name="btn_import" class="btn btn-primary">Simpan</button>
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

<script type="text/javascript">
  $('#modal-edit').on('show.bs.modal', function(e){
    var id = $(e.relatedTarget).data('id');
    var kode_barang = $(e.relatedTarget).data('kode');
    var nama_barang = $(e.relatedTarget).data('nama');
    var id_kategori = $(e.relatedTarget).data('kategori');
    var merek_id = $(e.relatedTarget).data('merek');
    var stok = $(e.relatedTarget).data('stok');
    var harga_beli = $(e.relatedTarget).data('harga_beli');
    var harga_jual = $(e.relatedTarget).data('harga_jual');
    var foto = $(e.relatedTarget).data('foto');
    if (!foto) {
      foto = 'barang_default.jpeg'; 
    }
    var src = '/storage/img/'+foto;
    var url = '/barang/update/'+id;
    
    $(e.currentTarget).find('input[name="kode_barang"]').val(kode_barang);
    $(e.currentTarget).find('input[name="nama_barang"]').val(nama_barang);
    $(e.currentTarget).find('select[name="id_kategori"]').val(id_kategori);
    $(e.currentTarget).find('select[name="merek_id"]').val(merek_id);
    $(e.currentTarget).find('input[name="stok"]').val(stok);
    $(e.currentTarget).find('input[name="harga_beli"]').val(harga_beli);
    $(e.currentTarget).find('input[name="harga_jual"]').val(harga_jual);
    document.getElementById('foto').src=src;
    $('#form-edit').attr('action',url);
  })
</script>
@endpush