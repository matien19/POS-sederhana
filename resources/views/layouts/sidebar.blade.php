<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <!-- Dashboard -->
        <li class="nav-item">
            <a href="{{ route('beranda') }}" class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}">
                <i class="nav-icon fas fa-home"></i>
                <p>Beranda</p>
            </a>
        </li>
        <!-- Kategori -->
        <li class="nav-item">
            <a href="{{ route('kategori') }}" class="nav-link {{ request()->routeIs('kategori') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tags"></i>
                <p>Kategori</p>
            </a>
        </li>
        <!-- Produk -->
        <li class="nav-item">
            <a href="{{ route('produk') }}" class="nav-link {{ request()->routeIs('produk*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-box"></i>
                <p>Produk</p>
            </a>
        </li>
    </ul>
</nav>
