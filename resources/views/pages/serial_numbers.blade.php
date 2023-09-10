@extends('layouts.posts_layout')

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
                                <hr>
                                <div class="row border-bottom mt-4 gx-0 mx-0">
                                    <div class="col-4 pb-3 border-end">
                                        <h6 class="fw-normal fs-5 mb-0">{{ __('Date lancement') }}</h6>
                                        <span class="fs-3 font-weight-medium text-primary" id="release_date"></span>
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
                                {{-- <div class="">

                                </div> --}}
                                <div class="col-12 mt-4 mx-0">
                                    <div class="row col-12 text-center">
                                        <div class="outer mx-auto">
                                            <canvas id="chartJSContainer" width="auto" height="auto"></canvas>
                                            <p class="percent" id="percent"></p>
                                        </div>
                                    </div>
                                    <div class="row border-top pb-3  mt-3 gx-0 mx-0">
                                        <div class="col-6 pt-3 border-end">
                                            <h6 class="fw-normal fs-5 mb-0">{{ __('OF') }}</h6>
                                            {{-- <span class="fs-3 font-weight-medium text-primary" id="release_date"></span> --}}
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">OK </div>
                                                    </div>
                                                    <span class="badge bg-success rounded-pill fs-4" id="count_list"></span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">OK / jour </div>
                                                    </div>
                                                    <span class="badge bg-danger rounded-pill fs-4"
                                                        id="quantity_valid_today"></span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-6 pt-3 border-end ps-3">
                                            <h6 class="fw-normal fs-5 mb-0">{{ __('Opérateur') }}</h6>
                                            <ul class="list-group list-group-flush">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">OK / jour </div>
                                                    </div>
                                                    <span class="badge bg-success rounded-pill fs-4"
                                                        id="user_valid_today"></span>
                                                </li>
                                                {{-- <li
                                                    class="list-group-item d-flex justify-content-between align-items-start">
                                                    <div class="ms-2 me-auto">
                                                        <div class="fw-bold">NOK / jour </div>
                                                    </div>
                                                    <span class="badge bg-danger rounded-pill"
                                                        id="NotvalidOperator">0</span>
                                                </li> --}}
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-5">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Ok par jour /
                                                        {{ Session::get('user_data')['username'] }}
                                                    </div>
                                                </div>
                                                <span class="badge bg-success rounded-pill" id="validOperator">0</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">NOk par jour /
                                                        {{ Session::get('user_data')['username'] }}
                                                    </div>
                                                </div>
                                                <span class="badge bg-danger rounded-pill" id="NotvalidOperator">0</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Ok de ce jour / OF</div>
                                                </div>
                                                <span class="badge bg-success rounded-pill" id="dayValidOF">0</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">Ok total / OF</div>
                                                </div>
                                                <span class="badge bg-success rounded-pill" id="validOF">0</span>
                                            </li>
                                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                                <div class="ms-2 me-auto">
                                                    <div class="fw-bold">NOk total / OF</div>
                                                </div>
                                                <span class="badge bg-danger rounded-pill" id="NotvalidOF">0</span>
                                            </li>

                                        </ul>
                                    </div> --}}
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
                    <button class="btn btn-info text-white form-inline" id="print_qr" style="display: inline-block;">
                        <i class="mdi mdi-printer mdi-24px"></i>
                        <span style="font-size: 18px">F1</span>
                    </button>
                    <span class="bg-danger" id="printer_alert"></span>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-sm table-hover  " width="100%">
                            <thead class="bg-light">
                                <tr>
                                    {{-- <th>{{ __('#') }}</th> --}}
                                    <th>{{ __('SN') }}</th>
                                    <th>{{ __('Créé le') }}</th>
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
            callAjax('POST', base_url + '/serial_numbers/qr_print', {
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
                callAjax("POST", base_url + '/serial_numbers', formData).done(function(response) {
                    if (response.status == false) {
                        return SessionErrors(response.message);
                    }
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
                    if (key == "count_list") {
                        // alert(key);
                        $("#" + key).text(value + ' /' + total_quantity_of);
                    } else
                        // alert(value)
                        $("#" + key).text(value);
                });
                // Do something with the fetched data
                //console.log(data.data.list);
                // $("#validOF").text(response.data.count_list);
                // // var errorMessage = encodeURIComponent(response.message);
                // // var redirectURL = "/?error=" + errorMessage;
                // // window.location.href = redirectURL;
                // $("#NotvalidOF").text(response.data.count_list);
                // $("#validOperator").text(response.data.count_list);
                // $("#NotvalidOperator").text(response.data.count_list);
                // $("#status").text(response.response.status);
                // $("#quantity_of_day").text(response.data.quantity_of_day);
                // $("#user_of_day").text(response.data.user_of_day);
                //alert(total_quantity_of);
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
                        labels: ["{{ __('  réalisé') }}", "{{ __('  à réaliser') }}"],
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
                table.DataTable({
                    "data": response.data.list,
                    columns: [{
                            data: 'serial_number'
                        },
                        {
                            data: 'updated_at'
                        },
                    ],
                    searching: false,
                    bLengthChange: false,
                    destroy: true,
                    order: [1, "desc"]
                });
            });
        }
    </script>
@endpush
