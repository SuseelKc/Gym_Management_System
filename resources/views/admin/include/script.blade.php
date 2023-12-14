{{-- DataTables --}}
<script src="{{ asset('admin/dist/js/jquery-3.6.0.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}">
</script>
<script src="{{ asset('admin/dist/js/jquery.dataTables.min.js') }}"></script>
{{-- End --}}
<!-- Bootstrap 4 -->
<script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
<script>
    jQuery(document).ready(function() {
        jQuery('.datepicker').datepicker({
            inline: true
        });
        jQuery('.datatable').DataTable();
    })
</script>
