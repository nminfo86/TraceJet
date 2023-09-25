@extends('layouts.posts_layout')
<style>
    .outer {
        position: relative;
        width: auto;
        height: auto;
    }

    /* canvas {
        position: absolute;
    } */

    .percent {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, 0);
        font-size: 40px;
        bottom: 0;
    }

    /* table.dataTable tr.dtrg-group th  is modified in datatable.min.css*/
</style>

<!--==============================================================-->
<!-- End PAge Content -->
<!-- ============================================================== -->

@push('custom_js')
    <script src="{{ asset('/dist/js/qrcode.min.js') }}"></script>
    <script src="{{ asset('dist/js/pages/posts.js') }}"></script>
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            formData = {
                "result": "OK"
            },
            url = base_url + '/packaging';
        /* -------------------------------------------------------------------------- */
        /*                                Valid Product                               */
        /* -------------------------------------------------------------------------- */
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();
            var qr = $("#qr").val();

            // Add more properties to the formData object
            formData.qr = qr;

            getSnTable(formData);
            $('form')[0].reset();
        });
        /* -------------------------------------------------------------------------- */
        /*                               Get OF information                           */
        /* -------------------------------------------------------------------------- */
        var total_quantity_of = 0;
        var percent = 0;
        var newPercent = 0;

        function getSnTable(formData) {
            // getOfDetails(of_id);
            postesDatatables(url, formData, "POST").done(function(response) {
                if (response.message !== "") {
                    // $("#printer_alert").text(response.message);
                    ajaxSuccess(response.message);
                    // return;
                }
                total_quantity_of = response.data.info.quantity ?? 0;
                $.each(response.data.info, function(key, value) {
                    key == "of_ok" ? $("#" + key).text(value + ' /' + total_quantity_of) : $("#" + key)
                        .text(value);
                });

                buildChart(response.data.info.of_ok, total_quantity_of, ["{{ __('  réalisé') }}",
                    "{{ __('  à réaliser') }}"
                ]);


                buildTable(response.data.list);

                if (response.data.box_ticket != undefined)
                    printBoxTicket(response.data.box_ticket)
                // return response.data.list;
            });
        }
    </script>
@endpush
