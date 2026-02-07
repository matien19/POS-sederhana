<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>POS</title>
  {{-- <link rel="icon" href="{{asset('/img/logo-icon.png')}}" type="image/x-icon" /> --}}
  @include('layouts.css')
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition sidebar-mini layouts-fixed layouts-navbar-fixed">
  <div class="wrapper">

    @include('layouts.navbar')
    @include('layouts.aside')

    <div class="content-wrapper">

      {{-- alert session action --}}
      @if(Session::has('status'))
      <div id="flash_alert" class="alert alert-info mt-3 flat" role="alert">
        {{ Session::get('message') }}
      </div>
      <script>
        $(function() {
          $('#flash_alert').delay(5000).hide(500);
        });
      </script>
      @endif

      {{-- alert session validate --}}
      @if ($errors->any())
      <div class="alert alert-danger mt-3 flat">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <form id="delete-form" method="POST" style="display:none;">
          @csrf
          @method('DELETE')
      </form>

      @yield('content')
    </div>

    @include('layouts.footer')
  </div>

  {{-- js --}}
  @include('layouts.js')
  @include('layouts.js_script')
  @stack('scripts')
</body>

</html>