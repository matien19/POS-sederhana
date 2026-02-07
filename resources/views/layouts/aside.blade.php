<!-- <style>
    .sidebar-orange {
        background-color: #d6651f !important;
    }

    /* Menu default */
    .sidebar-orange .nav-pills .nav-link {
        color: #ffffff !important;
        background-color: transparent !important;
        border-radius: 6px;
        margin: 2px 6px;
    }

    /* Hover (sedikit lebih terang) */
    .sidebar-orange .nav-pills .nav-link:hover {
        background-color: #e97a32 !important;
        color: #ffffff !important;
    }

    /* ACTIVE = warna background lama */
    .sidebar-orange .nav-pills .nav-link.active {
        background-color: #ef7e2e !important;
        color: #ffffff !important;
        font-weight: 600;
        box-shadow: inset 3px 0 0 #ffffff;
    }

    /* Icon */
    .sidebar-orange .nav-icon {
        color: #ffffff !important;
    }

    /* Treeview submenu */
    .sidebar-orange .nav-treeview>.nav-item>.nav-link {
        color: #ffffff !important;
        padding-left: 30px;
        font-size: 0.9rem;
    }

    /* Submenu active */
    .sidebar-orange .nav-treeview>.nav-item>.nav-link.active {
        background-color: #ef7e2e !important;
        box-shadow: inset 3px 0 0 #ffffff;
    }

    /* Arrow treeview */
    .sidebar-orange .nav-link .right {
        color: #ffffff !important;
    }

    /* Logo */
    .logo-container {
        background-color: #ffffff;
        padding: 14px;
        text-align: center;
        border-bottom: 1px solid rgba(0, 0, 0, .1);
    }

    .logo-container p:first-child {
        color: #d6651f;
        font-size: 1rem;
    }

    .logo-container p.small {
        color: #6c757d;
    }

    .layout-navbar-fixed.layout-fixed .wrapper .sidebar {
        margin-top: 0 !important;
    }

    .logo-mini {
        display: none;
    }

    .sidebar-collapse .logo-full {
        display: none;
    }

    .sidebar-collapse .logo-mini {
        display: block;
        text-align: center;
        color: #d6651f;
    }
</style> -->

<aside class="main-sidebar elevation-4 sidebar-orange">
    <style>
        .logo-container {
            background-color: #E5EAF0;
        }

        .layout-navbar-fixed.layout-fixed .wrapper .sidebar {
            margin-top: 0px;
        }
    </style>
    <div class="logo-container">
        {{-- <a class="navbar-logo">
            <img src="{!! url('/img/logo.png') !!}" alt="Logo " style="max-width: 40%; padding: 10px;">
        </a> --}}
        <p class="mb-0 fw-bold">POS</p>
        {{-- <p class="mb-0 small text-muted">Sistem Informasi Pengelolaan Anggaran</p> --}}
        

    </div>
    <!-- Sidebar -->
    <div class="sidebar">
        @include('layouts.sidebar')
        <!-- Sidebar Menu -->

    </div>
    <!-- /.sidebar -->
</aside>
