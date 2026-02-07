<!-- jQuery -->
<script src="{{ asset('template/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('template/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Bootstrap 4 -->
<script src="{{ url('/template/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('/template/dist/js/adminlte.min.js')}}"></script>
<!-- DataTables  & Plugins -->
<script src="{{url('/template/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{url('/template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{url('/template/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{url('/template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{url('/template/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('/template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{url('/template/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{url('/template/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{url('/template/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{url('/template/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{url('/template/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{url('/template/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- sweetalert -->
<script src="{{ url('/template/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- InputMask -->
<script src="{{ asset('template/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('template/plugins/inputmask/jquery.inputmask.min.js') }}"></script>

<!-- daterangepicker -->
<script src="{{ asset('template/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('template/plugins/toastr/toastr.min.js') }}"></script>
<script>
  var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });
</script>