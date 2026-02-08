@extends('layout.main')

@section('content')

<div class="col-lg-12">
    <div class="card">

        {{-- HEADER --}}
        <div class="card-header">
            <div class="card-title">
                <h4>
                    <i class="fas fa-bullhorn mr-2"></i> Pengumuman
                </h4>
            </div>
        </div>

        {{-- BODY --}}
        <div class="card-body">
            <div class="row">

                {{-- ================= FORM KIRI ================= --}}
                <div class="col-md-6">
                    <p class="text-muted font-weight-bold mb-3">Form Notifikasi</p>

                    <form action="{{ route('admin.pengumuman.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text"
                                   name="judul"
                                   class="form-control"
                                   placeholder="Judul pengumuman"
                                   required>
                        </div>

                        <div class="form-group">
                            <label>Isi Notifikasi</label>
                            <textarea name="isi"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Isi pengumuman"
                                      required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Pilih Tipe Penerima</label>
                            <select name="target" class="form-control" required>
                            <option value="semua">Semua User</option>
                            <option value="admin">Admin</option>
                            <option value="gudang">Gudang</option>
                            <option value="kasir">Kasir</option>
                        </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-block btn-lg">
                            <i class="fas fa-paper-plane mr-1"></i> Kirim
                        </button>

                        <p class="text-muted mt-2 text-center" style="font-size:13px">
                            Notifikasi akan dikirim sesuai tipe penerima yang dipilih
                        </p>
                    </form>
                </div>

                {{-- ================= LIST KANAN ================= --}}
                <div class="col-md-6">
                    <p class="text-muted font-weight-bold mb-3">Daftar Notifikasi</p>

                    <div class="border rounded p-3" style="height:360px; overflow-y:auto">

                        @forelse ($pengumuman as $p)
                            <div class="mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $p->judul }}</strong>
                                    <small class="text-muted">
                                        {{ ucfirst($p->target) }}
                                    </small>
                                </div>

                                <p class="mb-1 text-muted">
                                    {{ $p->isi }}
                                </p>

                                <small class="text-muted">
                                    {{ $p->created_at->format('d M Y H:i') }}
                                </small>

                                <hr>
                            </div>
                        @empty
                            <div class="text-center text-muted">
                                Belum ada pengumuman
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
