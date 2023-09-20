@extends('layouts.posts_layout')




@push('custom_js')
    <script src="{{ asset('dist/js/pages/posts.js') }}"></script>
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            url = base_url + '/serial_numbers',
            of_id,
            last_qr = "";

        $(document).ready(function() {
            /* -------------------------------------------------------------------------- */
            /*                                get ofs list                                */
            /* -------------------------------------------------------------------------- */
            callAjax('GET', base_url + '/pluck/ofs', {
                filter: "status",
            }).done(function(response) {
                if (response.status == false) {
                    return ajaxError(response.message);
                }
                appendToSelect(response.data, "#of_id");
            });
        });
        /* -------------------------------------------------------------------------- */
        /*                               Get OF information                           */
        /* -------------------------------------------------------------------------- */
        var total_quantity_of = 0;
        var percent = 0;
        var newPercent = 0;

        function getOfDetails(of_id) {
            callAjax('GET', base_url + '/of_details/' + of_id, {
                of_id: of_id
            }, false).done(function(response) {
                $.each(response, function(key, value) {
                    $("#" + key).text(value);
                });
                total_quantity_of = response.new_quantity;
                $(".of_number").removeClass('d-none')
                $(".of_info").removeClass("d-none");
                $("#qr").focus();
            });
        }

        function performAction() {
            callAjax('POST', url + '/qr_print', {
                of_id: of_id
            }).done(function(response) {
                // TODO::check status of response
                ajaxSuccess(response.message);
                // alert(response.data.qr);
            });
        }
        $(document).on("change", "#of_id", function(e) {
                e.preventDefault()
                of_id = $(this).val();
                getSnTable(of_id);
            })
            /* -------------------------------------------------------------------------- */
            /*                                Print QR code                               */
            /* -------------------------------------------------------------------------- */
            // Event handler for button click
            .on("click", "#print_qr", function(e) {
                e.preventDefault();
                performAction();
            })

            // Event handler for F1 key press
            .on("keydown", function(e) {
                if (e.which === 112) { // 112 is the keycode for F1 key
                    e.preventDefault();
                    performAction();
                }
            })
            /* -------------------------------------------------------------------------- */
            /*                                Valid Product                               */
            /* -------------------------------------------------------------------------- */
            .on('submit', 'form', function(e) {
                e.preventDefault();
                cleanValidationAlert();
                var formData = $(this).serialize() + '&of_id=' + of_id;
                $('form')[0].reset();
                callAjax("POST", url, formData).done(function(response) {
                    // if (response.status == false) {
                    //     return SessionErrors(response.message);
                    // }
                    getSnTable(of_id);
                    // TODO::Change later with samir
                    // getOfDetails(of_id);
                    ajaxSuccess(response.message);
                    $('#qr').val('');
                });

            });


        /* -------------------------------------------------------------------------- */
        /*                                 Fetch data                                 */
        /* -------------------------------------------------------------------------- */
        function getSnTable(of_id) {
            getOfDetails(of_id);
            postesDatatables(url, {
                "of_id": of_id
            }).done(function(response) {
                if (response.message !== "") {
                    $("#printer_alert").text(response.message);
                }
                $.each(response.data, function(key, value) {
                    key == "of_ok" ? $("#" + key).text(value + ' /' + total_quantity_of) : $("#" + key)
                        .text(value);
                });

                buildChart(response.data.of_ok, total_quantity_of, ["{{ __('  réalisé') }}",
                    "{{ __('  à réaliser') }}"
                ]);


                buildTable(response.data.list);
            });
        }
    </script>
@endpush
