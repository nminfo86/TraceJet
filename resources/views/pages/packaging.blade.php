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
</style>
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
                                <div class="col-12">
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
                                </div>
                                <hr />
                                <div class="col-12 d-flex justify-content-between  of_number ">
                                    <div class="">
                                        {{-- <h6 class="fw-normal text-dark mb-0 ">{{ __('Etat OF') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="status"></span> --}}
                                        <h5 class="fw-n"> {{ __('Etat OF') }} : <span
                                                class="badge bg-primary fs-4 font-weight-normal" id="status"></span>
                                        </h5>
                                    </div>
                                    <div class="">
                                        {{-- <h6 class="fw-normal text-dark mb-0">{{ __('OF Numéro') }}</h6>
                                        <span class=badge "fs-3 font-weight-medium text-info" id="of_number"></span> --}}
                                        <h5> {{ __('OF Numéro') }} : <span
                                                class="fs-3 font-weight-medium badge bg-primary text-white">0<span
                                                    id="of_number"></span></span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row of_number ">
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de serie') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="serial_number"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="box_qr"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  mt-4 ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('Qt PCS/ Carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="box_quantity"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  mt-4 ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('Etat carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="box_status"></span>
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-12 d- of_info ">
                    <div class="card shadow border-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row border-bottom mb-4 gx-0 mx-0">
                                    <div class="col-4 pb-3 border-end">
                                        <h6 class="fw-normal fs-5 mb-0">{{ __('Date lancement') }}</h6>
                                        <span class="fs-3 font-weight-medium text-primary" id="created_at"></span>
                                    </div>
                                    <div class="col-4 pb-3 border-end ps-3">
                                        <h6 class="fw-normal fs-5 mb-0">{{ __('Produit') }}</h6>
                                        <span class="fs-3 font-weight-medium text-primary" id="product_name"></span>
                                    </div>
                                    <div class="col-4 pb-3 border-end ps-3">
                                        <h6 class="fw-normal fs-5 mb-0">{{ __('Calibre') }}</h6>
                                        <span class="fs-3 font-weight-medium text-primary " id="caliber_name"></span>
                                    </div>
                                </div>
                                <div class="row mt-4 mx-0">
                                    <div class="col-lg-6 outer">
                                        <div class="">
                                            <canvas id="chartJSContainer" width="auto" height="auto"></canvas>
                                            <p class="percent" id="percent">
                                            </p>
                                        </div>
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
                                                                <span class="text-dark">OK / OF</span>
                                                                <h3 class="mb-0 text-primary">
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
                                                                <span class="text-dark">OK / Jour</span>

                                                                <h3 class="mb-0 text-primary">
                                                                    {{-- <span>0</span> / --}}
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
        <div class="col-lg-6  of_info">
            <div class="card shadow border-primary " style="min-height: 90vh">
                <div class="card-body text-white">
                    <button class="btn btn-info text-white" id="print_qr"><i class="mdi mdi-printer"></i>
                        {{ __('Générer QR') }}</button>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-sm table-hover  " width="100%">
                            <thead>
                                <tr class="">
                                    <th>{{ __('SN') }}</th>
                                    <th>{{ __('Date embalage') }}</th>
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

            /* -------------------------------------------------------------------------- */
            /*                                get ofs list                                */
            /* -------------------------------------------------------------------------- */
            callAjax('GET', base_url + '/pluck/ofs', {
                filter: id
            }).done(function(response) {
                appendToSelect(response.data, "#of_id");
            });


            /* -------------------------------- chart js -------------------------------- */
        });




        /* -------------------------------------------------------------------------- */
        /*                               Get OF information                           */
        /* -------------------------------------------------------------------------- */
        var total_quantity_of = 0;
        var percent = 0;
        var newPercent = 0;

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
                        $("#" + key).text(value);
                    });
                    total_quantity_of = response.quantity;
                    // $(".of_number").removeClass('')
                    // $(".of_info").removeClass("");
                    $("#qr").focus();
                });
            })
            /* -------------------------------------------------------------------------- */
            /*                                Print QR code                               */
            /* -------------------------------------------------------------------------- */
            .on("click", "#print_qr", function(e) {
                e.preventDefault();
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
                    $('#qr').val('');
                });

            });

        function getSnTable(formData) {
            return table.DataTable({
                ajax: {
                    type: 'POST',
                    url: base_url + '/packaging',
                    data: {
                        qr: formData,
                        mac: "mac5",
                        result: "OK"
                    },
                    dataSrc: function(response) {
                        $("#valid").text(response.data.list.length);
                        $("#status").text(response.data.status);
                        $("#quantity_of_day").text(response.data.quantity_of_day);
                        let x = (parseInt(response.data.list.length) / parseInt(
                            total_quantity_of));
                        percent = Number.parseFloat(x).toFixed(2) * 100;
                        $("#percent").text(percent + ' %');
                        let rest = 100 - percent;
                        newPercent = [percent, rest];
                        var options1 = {
                            type: 'doughnut',
                            data: {
                                labels: ["{{ __(' réalisé') }}", "{{ __('   à réaliser') }}"],
                                datasets: [{
                                    label: '# of Votes',
                                    data: [percent, rest],
                                    backgroundColor: [
                                        'rgba(46, 204, 113, 1)'
                                    ],
                                    borderColor: [
                                        'rgba(255, 255, 255 ,1)'
                                    ],
                                    borderWidth: 5
                                }]
                            },
                            options: {
                                rotation: 1 * Math.PI,
                                circumference: 1 * Math.PI,
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    enabled: false
                                },
                                cutoutPercentage: 85
                            }
                        }
                        var ctx1 = document.getElementById('chartJSContainer').getContext('2d');
                        var chart1 = new Chart(ctx1, options1);
                        //chart1.data.datasets.data = newPercent;
                        //chart1.update();
                        return response.data.list;
                    }
                },
                columns: [{
                        data: 'serial_number'
                    },
                    {
                        data: 'created_at'
                    },
                ],
                searching: false,
                bLengthChange: false,
                //info: false,
                // rowCallback: function(row, data) {
                //     $(row).css('background-color', 'rgba(203, 239, 179, 0.8)');
                // },
                destroy: true,
                columnDefs: [{
                    targets: -1,
                }, ],

                // initComplete: function() {

                //     let select = $('.dataTables_length ').unbind(),
                //         // self = this.api(),
                //         $printButton = $('<button class="btn btn-info text-white" id="print_qr">')
                //         .text(
                //             'Generer QR');
                //     $('.dataTables_length').html($printButton);

                // },
                order: [0, "desc"]
            });

        }
    </script>
@endpush
