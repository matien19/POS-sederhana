<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory | POS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="shortcut icon" href="{{ asset('template/dist/img/inventory.png') }}">

  @include('layout.components.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('template/dist/img/inventory.png') }}" alt="AdminLTELogo" height="100" width="100">
  </div>

        @include('layout.components.navbar')

       <aside class="main-sidebar sidebar-light-green elevation-4">
             <!-- Brand Logo -->
          
            <a href="/" class="brand-link">
                <img src="{{ asset('template/dist/img/inventory.png') }}" alt="Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light small">Inventory</span>
            </a>
            @include('layout.components.sidebar')
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid"></div>
            </div>

            <section class="content p-0">
                <div class="container-fluid p-0">
                    @yield('content')
                </div>
            </section>
        </div>

        @include('layout.components.footer')

        <aside class="control-sidebar control-sidebar-dark"></aside>
    </div>

    @include('layout.components.js')
    @stack('scripts')
    {{--  untuk nmbhin js ke js.blade.php --}}

</body>

</html>
