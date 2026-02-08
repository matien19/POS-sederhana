@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <div class="card p-4">

                {{-- HEADER PROFILE --}}
                <div class="row align-items-center mb-4">
                    <div class="col-md-3 text-center">

                        {{-- FORM UPLOAD FOTO --}}
                        <form action="{{ route(request()->segment(1).'.profile.foto') }}"
      method="POST"
      enctype="multipart/form-data"
      id="formUploadFoto">
                            @csrf
                            @method('PUT')

                            <img src="{{ $user->foto
                                ? asset('storage/profile/'.$user->foto)
                                : asset('img/default-user.png') }}"
                                class="rounded-circle mb-2"
                                width="110" height="110"
                                style="object-fit: cover; cursor:pointer"
                                onclick="document.getElementById('foto').click()">

                            <input type="file"
                                   name="foto"
                                   id="foto"
                                   accept="image/*"
                                   hidden
                                   onchange="document.getElementById('formUploadFoto').submit()">

                            <div class="mt-2">
                                <button type="button"
                                        class="btn btn-outline-secondary btn-sm"
                                        onclick="document.getElementById('foto').click()">
                                    <i class="fas fa-upload"></i> Unggah Foto
                                </button>
                            </div>
                        </form>

                        <div class="mt-2">
                            <a href="{{ route(request()->segment(1).'.profile.edit') }}"
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-edit"></i> Edit Profil
                            </a>
                        </div>

                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Nama</small>
                        <h5 class="text-secondary">{{ $user->name }}</h5>
                    </div>

                    <div class="col-md-3">
                        <small class="text-muted">Peran</small>
                        <h5 class="text-secondary">
                            {{ ucfirst($user->posisi) }}
                        </h5>
                    </div>
                </div>

                <hr>

                {{-- INFORMASI KONTAK --}}
                <h5 class="mb-3">Informasi kontak</h5>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>No. Telepon</strong>
                        <p class="mb-0">{{ $user->no_telepon }}</p>
                    </div>
                    <div class="col-md-6">
                        <strong>Email</strong>
                        <p class="mb-0">{{ $user->email }}</p>
                    </div>
                </div>

                <hr>

                {{-- PASSWORD --}}
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-1">Kata sandi</h6>
                        <p class="mb-0">••••••••</p>
                    </div>
                    <i class="fas fa-eye-slash text-muted"></i>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection