@extends('layouts.posts_layout')
{{-- <style>
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
</style> --}}

@push('custom_js')
    <script src="{{ asset('dist/js/pages/posts.js') }}"></script>
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            form_title = " {{ __('Nouveau Produit') }}",
            url = base_url + '/operators',
            of_id,
            formData = {};
        formToggle(form_title);

        $(document).ready(function() {

            /* -------------------------------------------------------------------------- */
            /*                                get ofs list                                */
            /* -------------------------------------------------------------------------- */
            callAjax('GET', base_url + '/pluck/ofs', {
                filter: "prod"
            }).done(function(response) {
                appendToSelect(response.data, "#of_id");
            });
        });




        /* -------------------------------------------------------------------------- */
        /*                               Get OF information                           */
        /* -------------------------------------------------------------------------- */
        var total_quantity_of = 0;
        var percent = 0;
        var newPercent = 0;
        var scanned_qr = 0;
        $(document).on("change", "#of_id", function(e) {
                e.preventDefault()
                // alert($("html").attr('lang'))
                of_id = $(this).val();
                formData.of_id = of_id;

                callAjax('GET', base_url + '/of_details/' + of_id, {
                    of_id: of_id
                }).done(function(response) {
                    $.each(response, function(key, value) {
                        $("#" + key).text(value);
                    });
                    total_quantity_of = response.new_quantity;
                    $(".of_number").removeClass('d-none')
                    $(".of_info").removeClass("d-none");
                    $("#qr").focus();
                    getSnTable(of_id);
                });
            })

            /* -------------------------------------------------------------------------- */
            /*                                Valid Product                               */
            /* -------------------------------------------------------------------------- */

            .on('submit', 'form', function(e) {
                e.preventDefault();
                cleanValidationAlert();
                let qr = $("#qr").val();

                if (scanned_qr != 0) {
                    if (scanned_qr == qr) {
                        formData.result = "OK";
                        storeQr(formData);
                    } else {
                        if (qr == "0000") {
                            formData.result = "NOK";
                            storeQr(formData);
                        } else {
                            getQr(formData, qr);
                        }
                    }
                } else {
                    getQr(formData, qr);
                }
            });

        function getSnTable(of_id) {
            // getOfDetails(of_id);
            postesDatatables(url, {
                "of_id": of_id
            }).done(function(response) {
                // if (response.message !== "") {
                // ajaxSuccess(response.message);
                // }
                $.each(response.data, function(key, value) {
                    if (key == "of_ok") {
                        // alert(key);
                        $("#" + key).text(value + ' /' + total_quantity_of);
                    } else
                        // alert(value)
                        $("#" + key).text(value);
                });

                buildChart(response.data.of_ok, total_quantity_of, ["{{ __('  réalisé') }}",
                    "{{ __('  à réaliser') }}"
                ]);

                buildTable(response.data.list);


            });
        }


        function getQr(formData, qr) {
            formData.qr = qr;

            callAjax("GET", url + '/' + qr, formData).done(function(response) {
                $("#qr").val("");

                ajaxSuccess(response.message);
                $("#scanned_qr").html(
                    `<div class="alert alert-success"><span class="font-weight-bolder h4"> vous pouvez intervenir sur le produit : ${response.data.serial_number}</span></div>`
                );
                scanned_qr = qr;
                // }
            });
        }

        function storeQr(formData) {
            callAjax("POST", url, formData).done(function(response) {
                // if (response.status == false) {
                //     return SessionErrors(response.message);
                // }
                getSnTable(of_id);
                ajaxSuccess(response.message);
                $('#qr').val('');
                scanned_qr = 0;
                $("#scanned_qr").html(`<strong class="h4"> Scanner un autre QR </strong>`);
            });
        }
    </script>
@endpush
