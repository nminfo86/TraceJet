@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Produits') }}</li>
@endsection

@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->

    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow border-primary">
                        <div class="card-body">
                            {{-- <div class="col-lg-12"> --}}
                            <div class=" row">
                                <label for="inputPassword" class="col-md-2 col-form-label">OF N° </label>
                                <div class="col-md-4 border-end">
                                    <select id="of_id" data-placeholder="{{ __('Selectionner une of') }}"
                                        name="of_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="of_id-error"></strong>
                                    </span>
                                </div>

                                <div class="col-md-3  of_number d-none ">
                                    <div class="col-12  border-end float-start ">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Etat OF') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="status"></span>
                                    </div>
                                </div>
                                <div class="col-md-3  of_number d-none ">
                                    <div class="col-12   float-start ">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('OF Numéro') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info">0</span>
                                        <span class="fs-3 font-weight-medium text-info" id="of_number"></span>
                                    </div>
                                </div>
                                {{-- </div> --}}
                                {{-- </div>
                                </div> --}}
                                {{-- <div class="col-lg-2">

                            </div> --}}
                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-12 d- of_info d-none">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">
                                <form id="main_form">
                                    <div class="row mx-0">
                                        <label for="inputPassword" class="col-md-1 "><i
                                                class="mdi mdi-24px mdi-barcode-scan"></i></label>
                                        <div class="col-md-11">
                                            <input type="text" class="form-control bg-light" id="qr"
                                                name="qr" onblur="this.focus()" autofocus>
                                            <span class="invalid-feedback" role="alert">
                                                <strong id="qr-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <input type="submit" class="d-none">
                                    {{-- <button class="btn-success">Submit</button> --}}
                                </form>
                                <hr>

                                <div class="row border-bottom mt-4 gx-0 mx-0">
                                    <div class="col-4 pb-3 border-end">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Date lancement') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="created_at"></span>
                                    </div>
                                    <div class="col-4 pb-3 border-end ps-3">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Produit') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="product_name"></span>
                                    </div>
                                    <div class="col-4 pb-3 border-end ps-3">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Calibre') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info " id="caliber_name"></span>
                                    </div>
                                </div>
                                <div class="row mt-4 mx-0">
                                    <div class="col-lg-6">

                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div
                                                                class=" round rounded-circle text-white d-inline-block text-center bg-success">
                                                                <i class="mdi mdi-check mdi-36px"></i>
                                                            </div>
                                                            <div class="ms-3 align-self-center">
                                                                <span class="text-muted">OK / OF</span>
                                                                <h3 class="mb-0 text-info">
                                                                    <span id="valid"></span> /
                                                                    <span id="quantity"></span>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <div class="d-flex flex-row align-items-center">
                                                            <div
                                                                class=" round rounded-circle text-white d-inline-block text-center bg-danger">
                                                                <i class="mdi mdi-36px mdi-calendar-clock"></i>
                                                            </div>
                                                            <div class="ms-3 align-self-center">
                                                                <span class="text-muted">OK / Jour</span>

                                                                <h3 class="mb-0 text-info">
                                                                    <span>0</span> /
                                                                    <span id="quantity_of_day"></span>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 d-none of_info">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="main_table" class="table table-sm table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    <th>{{ __('serial_number') }}</th>
                                    <th>{{ __('QR') }}</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--==============================================================-->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection
@push('custom_js')
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            form_title = " {{ __('Nouveau Produit') }}",
            url = base_url + '/serial_numbers',
            of_id,
            last_qr = "";
        formToggle(form_title);

        $(document).ready(function() {

        });

        /* -------------------------------------------------------------------------- */
        /*                          get ofs list with status                          */
        /* -------------------------------------------------------------------------- */
        callAjax('GET', base_url + '/pluck/ofs', {
            filter: "status"
        }).done(function(response) {
            $.each(response.data, function(i, val) {
                $("#of_id").append(
                    `<option data-status="${val.status}" value=${val.id}>${val.of_code}</option>`
                )
            });
        });

        /* -------------------------------------------------------------------------- */
        /*                               Get OF information                           */
        /* -------------------------------------------------------------------------- */
        $(document).on("change", "#of_id", function(e) {
                e.preventDefault()
                let status = $(this).find(':selected').data('status');
                of_id = $(this).val();
                $("#of_status").text(status);
                getSnTable(of_id);

                // getSnTable(of_id)
                callAjax('GET', base_url + '/of_details/' + of_id, {
                    of_id: of_id
                }).done(function(response) {
                    $.each(response, function(key, value) {
                        // console.log(key + "=" + value);
                        $("#" + key).text(value);
                    });

                    $(".of_number").removeClass('d-none')
                    $(".of_info").removeClass("d-none");
                    $("#qr").focus();

                });




            })
            /* -------------------------------------------------------------------------- */
            /*                                Print QR code                               */
            /* -------------------------------------------------------------------------- */
            .on("click", "#print_qr", function(e) {
                e.preventDefault();
                // console.log(of_id);
                callAjax('POST', base_url + '/serial_numbers/qr_print', {
                    of_id: of_id
                }).done(function(response) {
                    ajaxSuccess(response.message)
                });
            })
            /* -------------------------------------------------------------------------- */
            /*                                Valid Product                               */
            /* -------------------------------------------------------------------------- */
            .on('submit', 'form', function(e) {
                e.preventDefault();
                cleanValidationAlert();
                var formData = $(this).serialize() + '&of_id=' + of_id;
                callAjax("POST", base_url + '/serial_numbers', formData).done(function(response) {
                    if (response.status == false) {
                        return SessionErrors(response.message);
                    }
                    getSnTable(of_id);
                    ajaxSuccess(response.message);

                });

            });






        function getSnTable(of_id) {
            return table.DataTable({
                ajax: {
                    type: 'GET',
                    url: url,
                    data: {
                        "of_id": of_id
                    },

                    dataSrc: function(response) {
                        $("#valid").text(response.data.list.length);
                        $("#status").text(response.data.status);
                        $("#quantity_of_day").text(response.data.quantity_of_day);

                        return response.data.list;
                    }
                },
                columns: [{
                        data: 'serial_number'
                    },
                    {
                        data: 'qr'
                    },
                ],
                rowCallback: function(row, data) {
                    $(row).css('background-color', 'rgba(203, 239, 179, 0.8)');
                },
                destroy: true,
                columnDefs: [{
                    targets: -1,
                }, ],

                initComplete: function() {

                    let select = $('.dataTables_length ').unbind(),
                        // self = this.api(),
                        $printButton = $('<button class="btn btn-info text-white" id="print_qr">')
                        .text(
                            'Generer QR');
                    $('.dataTables_length').html($printButton);

                },
                order: [0, "desc"]
            });

        }
    </script>
@endpush
