<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->

<script src="{{ asset('/dist/js/datatables.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="{{ asset('/dist/js/app-style-switcher.js') }}"></script> --}}

<script src="{{ asset('/dist/js/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('/dist/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('/dist/js/daterangepicker.min.js') }}"></script>

<!--Wave Effects -->
<script src="{{ asset('/dist/js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('/dist/js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('/dist/js/custom.js') }}"></script>

{{-- SweetAlert --}}
<script src="{{ asset('/dist/js/sweetalert2.all.min.js') }}"></script>

{{-- Select2 --}}
<script src="{{ asset('/dist/js/select2/select2.min.js') }}"></script>
<script src="{{ asset('/dist/js/select2/fr.js') }}"></script>
<script src="{{ asset('/dist/js/popper.js') }}"></script>
<script src="{{ asset('/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('/dist/js/main.js') }}"></script>

<script src="{{ asset('/dist/js/appCore.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            'Authorization': 'Bearer ' + '{{ Session::get('token') }}',
            'Accept-Language': $("html").attr('lang')
            //  'Accept-Language': "fr"
        }
    });
    $.extend(true, $.fn.dataTable.defaults, {
        //processing: true,
        columnDefs: [{
            targets: -1,
            className: "text-center"
        }, ],

        //  ajax: {
        //       error: function(jqXHR, exception) {
        //           showAjaxAndValidationErrors(jqXHR, exception)
        //       }
        //   },
        language: {
            url: "{{ asset('') }}assets/locale/{{ LaravelLocalization::getCurrentLocale() }}.json"
        },
    });
    var yes = "{{ __('Oui') }}";
    var no = "{{ __('Non') }}";
    var realised = "{{ __('réalisé') }}";
    var to_realise = "{{ __('à réaliser') }}";
</script>
<!-- Costum js code for each child-->
@stack('custom_js')
<!-- END: Costum js code -->
