@extends('layouts.posts_layout')

@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    {{-- <div class="row d-flex align-items-stretch">
        <div class="col-lg-6 flex-fill">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow border-primary">
                        <div class="card-body">
                            <div class=" row">
                                <label
                                    class="col-sm-3 col-form-label text-dark fs-5 fw-normal">{{ __('Selectionner un OF') }} :
                                </label>
                                <div class="col-sm-9">
                                    <select id="of_id" class="form-control"
                                        data-placeholder="{{ __('Selectionner un OF') }}" name="of_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="of_id-error"></strong>
                                    </span>
                                </div>
                                <hr class="of_number d-none mt-4" />
                                <div class="col-12 d-flex justify-content-between  of_number d-none">
                                    <div class="">
                                        <h5 class="fw-n"> {{ __('Etat OF') }} : <span
                                                class="badge bg-primary fs-4 font-weight-normal" id="status"></span>
                                        </h5>
                                    </div>
                                    <div class="">
                                        <h5> {{ __('OF Numéro') }} : <span
                                                class="fs-3 font-weight-medium badge bg-primary text-white"
                                                id="of_number"></span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 d- of_info d-none">
                    <div class="card shadow border-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <form id="main_form">
                                    <div class="row mx-0">
                                        <label class="col-md-1 "><i class="mdi mdi-24px mdi-barcode-scan"></i></label>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control bg-light" id="qr"
                                                name="qr" onblur="this.focus()" autofocus>
                                            <span class="invalid-feedback" role="alert">
                                                <strong id="qr-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="submit" class="d-none">
                                </form>
                                <hr> --}}

    {{-- @include('components.posts') --}}


    {{-- </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 flex-fill d-none of_info">
                                <div class="card shadow border-primary" style="min-height: 90vh">
                                    <div class="card-body text-white">
                                        <button class="btn btn-info text-white form-inline" id="print_qr" style="display: inline-block;">
                                            <i class="mdi mdi-printer mdi-24px"></i>
                                            <span style="font-size: 18px">F1</span>
                                        </button>
                                        <span class="bg-danger" id="printer_alert"></span>
                                        <div class="table-responsive">
                                            <table id="main_table" class="table table-sm table-hover  " width="100%">
                                                <thead class="bg-light">
                                                    <tr>

                                                        <th>{{ __('SN') }}</th>
                                                        <th>{{ __('Créé le') }}</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
    {{-- </div> --}}

    <!--==============================================================-->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection



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
