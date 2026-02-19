<aside class="main-sidebar custom-sidebar elevation-4">
    <!-- Brand -->
    <a href="#" class="brand-link text-center">
        <span class="brand-text font-weight-bold">
            Inventory
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                {{-- ================= DATA MASTER ================= --}}
                @php
                $dataMasterActive =
                request()->routeIs('barang*') ||
                request()->routeIs('kategori*') ||
                request()->routeIs('merek*') ||
                request()->routeIs('supplier*');

                @endphp

                <li class="nav-item has-treeview {{ $dataMasterActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $dataMasterActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-database"></i>
                        <p>
                            Data Master
                            <i class="right fas fa-angle-right arrow"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('kategori') }}"
                                class="nav-link {{ request()->routeIs('kategori*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kategori Barang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('merek') }}"
                                class="nav-link {{ request()->routeIs('merek*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Merek Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('barang') }}"
                                class="nav-link {{ request()->routeIs('barang*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('supplier') }}"
                                class="nav-link {{ request()->routeIs('supplier*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supplier</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('retur') }}"
                        class="nav-link {{ request()->routeIs('retur') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-undo"></i>
                        <p>Retur</p>
                    </a>
                </li>

                {{-- ================= KATEGORI TRANSAKSI ================= --}}
                @php
                $transaksiActive = request()->routeIs('pembelian*') || request()->routeIs('penjualan*');
                @endphp

                <li class="nav-item has-treeview {{ $transaksiActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $transaksiActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>
                            Kategori Transaksi
                            <i class="right fas fa-angle-right arrow"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('pembelian.tambah') }}"
                                class="nav-link {{ request()->routeIs('pembelian.tambah') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-box-open"></i>
                                <p>Tambah Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('pembelian') }}"
                                class="nav-link {{ request()->routeIs('pembelian') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penjualan.tambah') }}"
                                class="nav-link {{ request()->routeIs('penjualan.tambah') ? 'active' : '' }}"><i
                                    class="nav-icon fas fa-shopping-cart"></i>
                                <p>Transaksi Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('penjualan.index') }}"
                                class="nav-link {{ request()->routeIs('penjualan.index') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penjualan</p>
                            </a>
                        </li>
                    </ul>
                </li>



                {{-- ================= MANAJEMEN STOK ================= --}}
                @php
                $stokActive =
                request()->routeIs('stok.barang*') ||
                request()->routeIs('stok.masuk*') ||
                request()->routeIs('stok.keluar*');
                @endphp

                <li class="nav-item has-treeview {{ $stokActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $stokActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Manajemen Stok
                            <i class="right fas fa-angle-right arrow"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('stok.barang') }}"
                                class="nav-link {{ request()->routeIs('stok.barang*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stok Barang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('stok.masuk') }}"
                                class="nav-link {{ request()->routeIs('stok.masuk*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barang Masuk</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('stok.keluar') }}"
                                class="nav-link {{ request()->routeIs('stok.keluar*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Barang Keluar</p>
                            </a>
                        </li>

                    </ul>
                </li>


                {{-- ================= LAPORAN ================= --}}
                @php
                $laporanActive =
                request()->routeIs('laporan.pembelian*') || request()->routeIs('laporan.penjualan*');
                @endphp

                <li class="nav-item has-treeview {{ $laporanActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $laporanActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Laporan
                            <i class="right fas fa-angle-right arrow"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('laporan.pembelian') }}"
                                class="nav-link {{ request()->routeIs('laporan.pembelian*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pembelian</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('laporan.penjualan') }}"
                                class="nav-link {{ request()->routeIs('laporan.penjualan*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Penjualan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ================= MANAJEMEN USER ================= --}}
                {{-- @php
                $userActive =
                request()->routeIs('user.admin*') ||
                request()->routeIs('user.gudang*') ||
                request()->routeIs('user.kasir*');
                @endphp

                <li class="nav-item has-treeview {{ $userActive ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $userActive ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users-cog"></i>
                        <p>
                            Manajemen User
                            <i class="right fas fa-angle-right arrow"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('user.admin') }}"
                                class="nav-link {{ request()->routeIs('user.admin*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Admin</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.gudang') }}"
                                class="nav-link {{ request()->routeIs('user.gudang*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Staff Gudang</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('user.kasir') }}"
                                class="nav-link {{ request()->routeIs('user.kasir*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kasir</p>
                            </a>
                        </li>
                    </ul>
                </li> --}}
                {{-- Pengumuman --}}
                {{-- <li class="nav-item">
                    <a href="{{ route('pengumuman') }}"
                        class="nav-link {{ request()->routeIs('pengumuman*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>Pengumuman</p>
                    </a>
                </li> --}}

                {{--
                <li class="nav-item">
                    <a href="{{ route('kasir.dashboard') }}"
                        class="nav-link {{ request()->routeIs('kasir.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('kasir.penjualan') }}"
                        class="nav-link {{ request()->routeIs('kasir.penjualan') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-shopping-cart"></i>
                        <p>Transaksi Penjualan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kasir.transaksi') }}"
                        class="nav-link {{ request()->routeIs('kasir.transaksi') ? 'active' : '' }}"><i
                            class="nav-icon fas fa-receipt"></i>
                        <p>Riwayat Transaksi</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kasir.laporan') }}"
                        class="nav-link {{ request()->routeIs('kasir.laporan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Laporan</p>
                    </a>
                </li> --}}

                {{-- ======================================================
                | GUDANG
                ====================================================== --}}

                {{-- <li class="nav-item">
                    <a href="{{ route('gudang.dashboard') }}"
                        class="nav-link {{ request()->routeIs('gudang.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>



                {{-- ================= LOGOUT ================= --}}
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link btnLogoutSidebar">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li> --}}
            </ul>
        </nav>
    </div>
</aside>