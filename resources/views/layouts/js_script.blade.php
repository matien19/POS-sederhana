<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": []
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });



    // Toast function
    function showToast(type, message) {
        if (!message) return;

        let icon = 'info';
        if (type === 'success') icon = 'success';
        if (type === 'warning') icon = 'warning';
        if (type === 'error') icon = 'error';

        Toast.fire({
            icon: icon,
            title: message
        });
    }
    // menerima session flashdata dari controller
    function autoShowSessionToast(sessionData) {
        if (!sessionData) return;
        Object.entries(sessionData).forEach(([type, msg]) => {
            if (msg) showToast(type, msg);
        });
    }

</script>

<script>
    function confirmDelete(url, button = null) {
        Swal.fire({
            title: "Hapus Data",
            text: "Apakah Anda yakin ingin menghapus data?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                if (button) {
                    button.setAttribute('disabled', 'disabled');
                    button.innerHTML =
                        '<i class="fa fa-spinner fa-spin mr-1"></i> Menghapus';
                }

                const form = document.getElementById('delete-form');
                form.action = url;
                form.submit();
            }
        });
    }
</script>
