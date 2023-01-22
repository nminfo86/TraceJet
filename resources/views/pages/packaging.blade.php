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
            <div class="card border-primary bg-light">
                <div class="card-body">
                    <form id="main_form">
                        <div class="row mx-0">
                            <label for="inputPassword" class="col-md-1 "><i class="mdi mdi-24px mdi-barcode-scan"></i></label>
                            <div class="col-md-11">
                                <input type="text" class="form-control" id="qr" name="qr"
                                    onblur="this.focus()" autofocus placeholder="Scanner un code QR">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="qr-error"></strong>
                                </span>
                            </div>
                        </div>
                        <input type="submit" class="d-none">
                        {{-- <button class="btn-success">Submit</button> --}}
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 h-auto">
            <div class="card border-primary bg-light">
                <div class="card-body">
                    <div class="text-danger"> Attention !! changement d'OF

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-12">
                    <div class="card border-primary bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12  of_number ">
                                    <div class="col-12 border-start border-secondary mb-4 ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° OF') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de serie') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  mt-4 ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('Qt PCS/ Carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  mt-4 ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('Etat carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-primary bg-light">
                        <div class="card-body">
                            {{-- <div class="row">
                                <div class="col-12  of_number ">
                                    <div class="col-12 border-start border-secondary mb-4 ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° OF') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de serie') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  mt-4 ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('Qt PCS/ Carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  mt-4 ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('Etat carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="table-responsive">
                                <div class="row border-bottom mt-4 gx-0 mx-0">
                                    <div class="col-4 pb-3 border-end">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Date lancement') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="of_date">Oct 23, 2021</span>
                                    </div>
                                    <div class="col-4 pb-3 border-end ps-3">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Produit') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="product">$63,000</span>
                                    </div>
                                    <div class="col-4 pb-3 border-end ps-3">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Calibre') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info " id="caliber">$98,500</span>
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
                                                                <h3 class="mb-0 text-info" id="qty_ok"></h3>
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
                                                                <h3 class="mb-0 text-info" id="qty_day">2500</h3>
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
        <div class="col-lg-6 of_info">
            <div class="card border-primary bg-light">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="main_table" class="table table-sm table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    <th>{{ __('N° de serie') }}</th>
                                    <th>{{ __('Date emballage') }}</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
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

                getSnTable(of_id)
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
                var formData = $(this).serialize() + '&of_id=' + of_id;
                $.ajax({
                    type: "POST",
                    url: base_url + '/serial_numbers',
                    data: formData, // serializes the form's elements.
                    success: function(response) {
                        if (response.status == false) {
                            return SessionErrors(response.message);
                        }
                        getSnTable(of_id);
                        return ajaxSuccess(response.message);
                    }
                });
            });


        function getSnTable(of_id) {
            return table.DataTable({
                // "ajax": url,
                ajax: {
                    type: 'GET',
                    url: url,
                    data: {
                        "of_id": of_id
                    },

                    dataSrc: function(response) {

                        $("#of_date").text(response.data.created_at);
                        $("#of_status").text(response.data.status);
                        $("#product").text(response.data.product_name);
                        $("#caliber").text(response.data.caliber_name);
                        $("#qty_ok").text("0" + response.data.sn_list.length + " / 0" +
                            response.data.quantity);
                        $(".of_number").removeClass('d-none').find('#of_number').text("0" +
                            response
                            .data
                            .of_number);

                        $(".of_info").removeClass("d-none");
                        $("#qr").focus();
                        return response.data.sn_list;

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
