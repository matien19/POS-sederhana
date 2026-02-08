@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card p-4">
                <h4 class="mb-3">Edit Profil</h4>
                <hr>

                <form method="POST"
                      action="{{ route(request()->segment(1).'.profile.update') }}">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email"
                               name="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}"
                               required>
                    </div>

                    {{-- Telepon --}}
                    <div class="form-group">
                        <label>No. Telepon</label>
                        <input type="text"
                               name="no_telepon"
                               class="form-control"
                               value="{{ old('no_telepon', $user->no_telepon) }}"
                               required>
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="Kosongkan jika tidak diubah">
                    </div>

                    {{-- Konfirmasi --}}
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="form-control">
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route(request()->segment(1).'.profile') }}"
                           class="btn btn-secondary px-4">
                            Kembali
                        </a>

                        <button type="submit"
                                class="btn btn-primary px-4">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection
