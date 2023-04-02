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
                                <label for="inputPassword"
                                    class="col-sm-3 col-form-label text-dark fs-5 fw-normal">{{ __('Selectionner un OF') }} :
                                </label>
                                <div class="col-sm-9">
                                    <select id="of_id" class="form-control"
                                        data-placeholder="{{ __('Selectionner une of') }}" name="of_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="of_id-error"></strong>
                                    </span>
                                </div>
                                <hr class="of_number d-none mt-4" />
                                <div class="col-12 d-flex justify-content-between  of_number d-none">
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
                                                class="fs-3 font-weight-medium badge bg-primary text-white"
                                                id="of_number"></span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>

                <div class="col-12 d- of_info d-none">
                    <div class="card shadow border-primary">
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
                                <div class="text-center" id="scanned_qr"> Scanner un numéro de serie pour voir son état

                                </div>
                                <hr>

                                <div class="row border-bottom mt-4 gx-0 mx-0">
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
        <div class="col-lg-6 d-none of_info">
            <div class="card shadow border-primary" style="min-height: 90vh">
                <div class="card-body text-white">
                    <div class="table-responsive">
                        <table id="main_table" class="table table-sm table-hover  " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>{{ __('#') }}</th> --}}
                                    <th>{{ __('SN') }}</th>
                                    <th>{{ __('Created_at') }}</th>
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
                of_id = $(this).val();
                // alert(of_id);
                getSnTable(of_id);

                callAjax('GET', base_url + '/of_details/' + of_id, {
                    of_id: of_id
                }).done(function(response) {
                    $.each(response, function(key, value) {
                        $("#" + key).text(value);
                    });
                    total_quantity_of = response.quantity;
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
                let qr = $("#qr").val();
                if (scanned_qr != 0) {
                    if (scanned_qr == qr) {
                        var formData = $(this).serialize() + '&of_id=' + of_id + '&mac=mac2' + '&result=ok';
                        callAjax("POST", base_url + '/operators', formData).done(function(response) {
                            if (response.status == false) {
                                return SessionErrors(response.message);
                            }
                            getSnTable(of_id);
                            ajaxSuccess(response.message);
                            $('#qr').val('');
                            scanned_qr = 0;
                            $("#scanned_qr").html(
                                `scanner un autre QR`);
                        });
                    } else {
                        //$("#scanned_qr").html(
                        //  `<i class="mdi mdi-close-circle mdi-18px"></i> scanner le code qr d'abord`);
                        var formData = {
                            "qr": qr,
                            "of_id": of_id,
                            "mac": "mac2",
                            "result": "NOK"
                        };
                        callAjax("POST", base_url + '/operators', formData).done(function(response) {
                            if (response.status == false) {
                                return SessionErrors(response.message);
                            }
                            getSnTable(of_id);
                            ajaxSuccess(response.message);
                            $('#qr').val('');
                            scanned_qr = 0;
                            $("#scanned_qr").html(
                                `scanner un autre QR`);
                        });
                    }
                } else {
                    var formData = $(this).serialize() + '&of_id=' + of_id + '&mac=mac2';
                    callAjax("GET", base_url + '/operators', formData).done(function(response) {
                        if (response.status == false) {
                            return SessionErrors(response.message);
                        }
                        getSnTable(of_id);
                        ajaxSuccess(response.message);
                        $('#qr').val('');
                        if (response.data.result == "ok") {
                            $("#scanned_qr").html(
                                `<i class="mdi mdi-check-circle mdi-18px text-success"></i> ${response.data.serial_number}`
                            );
                            scanned_qr = qr;
                        } else
                            $("#scanned_qr").html(
                                `<i class="mdi mdi-close-circle mdi-18px"></i> qr invalid`);
                    });
                }
            });
        /* -------------------------------------------------------------------------- */
        /*                                 Fetch data                                 */
        /* -------------------------------------------------------------------------- */
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
                        let x = (parseInt(response.data.list.length) / parseInt(
                            total_quantity_of));
                        percent = Math.floor(x * 100);
                        $("#percent").text(percent + ' %');
                        let rest = 0;
                        if (percent < 100) {
                            rest = 100 - percent;
                        }
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
                        return response.data.list;
                    }
                },
                columns: [
                    // {
                    //     data: 'id'
                    // },
                    {
                        data: 'serial_number'
                    },
                    {
                        data: 'created_at'
                    },
                ],
                searching: false,
                bLengthChange: false,
                destroy: true,
                order: [0, "asc"]
            });

        }
    </script>
@endpush
