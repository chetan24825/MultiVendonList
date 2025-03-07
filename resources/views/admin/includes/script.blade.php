<script src="{{ asset('panel/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('panel/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('panel/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('panel/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('panel/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('panel/js/app.js') }}"></script>
<script src="{{ asset('aizfiles/aiz-core.js') }}"></script>
@stack('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        AIZ.plugins.aizUppy();
    });
</script>

