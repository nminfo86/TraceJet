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
                            <div class=" row">
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
                                </form>
                                <hr class="of_number  mt-2" />
                                <div class="col-12 d-flex justify-content-between  of_number ">
                                    <div class="">
                                        <h5 class="fw-n"> {{ __('Etat OF') }} : <span
                                                class="badge bg-primary fs-4 font-weight-normal" id="status"></span>
                                        </h5>
                                    </div>
                                    <div class="">
                                        <h5> {{ __('OF Numéro') }} : <span
                                                class="fs-3 font-weight-medium badge bg-primary text-white">0<span
                                                    id="of_number"></span></span>
                                        </h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de serie') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="serial_number"></span>
                                    </div>
                                </div>
                                <div class="col-md-6  of_number ">
                                    <div class="col-12 border-start border-secondary float-start ">
                                        <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° de carton') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info ms-2" id="box_number"></span>
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

                <div class="col-12 of_info ">
                    <div class="card shadow border-primary">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row border-bottom mb-4 gx-0 mx-0">
                                    <div class="col-4 pb-3 border-end">
                                        <h6 class="fw-normal text-muted mb-0">
                                            {{ __('Date lancement') }}</h6>
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
                                                                <span id="packged_products"></span> /
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
                                                            <i class="mdi mdi-36px mdi-cube"></i>
                                                        </div>
                                                        <div class="ms-3 align-self-center">
                                                            <span class="text-dark">{{ __('Carton à emballer') }}</span>
                                                            <h3 class="mb-0 text-primary">
                                                                <span id="of_boxes"></span>
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
        <div class="col-lg-6  of_info">
            <div class="card shadow border-primary " style="min-height: 90vh">
                <div class="card-body text-white">
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
            formData = {
                // "qr": scanned_qr,
                // "of_id": of_id,
                // "lang": "fr",
                // "mac": "{{ Session::get('user_data')['post_information']['mac'] }}",
                "previous_post_id": "{{ Session::get('user_data')['post_information']['previous_post_id'] }}",
                //  "post_name": "{{ Session::get('user_data')['post_information']['post_name'] }}",
                // "posts_type_id": "{{ Session::get('user_data')['post_information']['posts_type_id'] }}",
                "host_id": "{{ Session::get('user_data')['post_information']['id'] }}",
                "result": "OK",
                // "ip_address": "{{ Session::get('user_data')['post_information']['ip_address'] }}",
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
            $("#qr").val('');
        });
        /* -------------------------------------------------------------------------- */
        /*                               Get OF information                           */
        /* -------------------------------------------------------------------------- */
        var total_quantity_of = 0;
        var percent = 0;
        var newPercent = 0;

        function getSnTable(formData) {

            return table.DataTable({
                ajax: {
                    type: 'POST',
                    url: base_url + '/packaging',
                    data: formData,
                    // data: {
                    //     qr: formData,
                    //     mac: "mac5",
                    //     result: "OK"
                    // },
                    dataSrc: function(response) {
                        if (response.status == true) {
                            $.each(response.data.info, function(k, v) {
                                $("#" + k).text(v);
                            });
                            $('#packged_products').text(response.data.list.length);
                            $("#qr").focus();
                            total_quantity_of = response.data.info.quantity;
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
                        return SessionErrors(response.message);
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
                destroy: true,
                columnDefs: [{
                    targets: -1,
                }, ],
                order: [0, "desc"]
            });
        }
    </script>
@endpush
