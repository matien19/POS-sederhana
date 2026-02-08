@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    $user = Auth::user();

    $notifikasi = collect();

    if ($user && Schema::hasTable('pengumuman_user')) {
        $notifikasi = $user
            ->pengumuman()
            ->wherePivot('is_read', false)
            ->latest()
            ->take(5)
            ->get();
    }
@endphp

<nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- LEFT -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#">
                <i class="fas fa-bars"></i>
            </a>
        </li>
    </ul>

    <!-- RIGHT -->
    <ul class="navbar-nav ml-auto">

        <!-- 🔔 NOTIFICATION -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-bell"></i>

                @if ($notifikasi->count() > 0)
                    <span class="badge badge-danger navbar-badge">
                        {{ $notifikasi->count() }}
                    </span>
                @endif
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <span class="dropdown-header">
                    {{ $notifikasi->count() }} Notifikasi Baru
                </span>

                <div class="dropdown-divider"></div>

                @forelse ($notifikasi as $n)
                    <a href="#"
                       class="dropdown-item">
                        <i class="fas fa-bullhorn mr-2 text-warning"></i>
                        <strong>{{ $n->judul }}</strong>

                        <p class="text-muted mb-0" style="font-size:13px">
                            {{ Str::limit($n->isi, 50) }}
                        </p>

                        <span class="float-right text-muted text-sm">
                            {{ $n->created_at->diffForHumans() }}
                        </span>
                    </a>

                    <div class="dropdown-divider"></div>
                @empty
                    <div class="dropdown-item text-center text-muted">
                        Tidak ada notifikasi
                    </div>
                @endforelse

            </div>
        </li>

        <!-- 👤 PROFILE -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                {{-- <img src="{{ $user->foto
                    ? asset('storage/profile/'.$user->foto)
                    : asset('img/default-user.png') }}"
                    class="rounded-circle mr-2"
                    width="32" height="32"
                    style="object-fit: cover">

                {{ $user->name }} --}}
            </a>

            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                <div class="dropdown-item text-center">
                    {{-- <img src="{{ $user->foto
                        ? asset('storage/profile/'.$user->foto)
                        : asset('img/default-user.png') }}"
                        class="img-circle mb-2"
                        width="60" height="60">

                    <p class="mb-0 font-weight-bold">{{ $user->name }}</p>
                    <small class="text-muted">
                        {{ ucfirst($user->posisi) }}
                    </small> --}}
                </div>

                <div class="dropdown-divider"></div>

                <a href="#" class="dropdown-item btnLogoutNavbar">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>

            </div>
        </li>

    </ul>
</nav>
