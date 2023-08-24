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
                                                            <span class="text-dark">{{ __('OK / OF') }}</span>
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
                                        {{-- <button id="print">print</button> --}}
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
                            <thead class="bg-light">
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
    <div class="d-none" id="qr_code"></div>

    <!--==============================================================-->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection

<!--==============================================================-->
<!-- End PAge Content -->
<!-- ============================================================== -->

@push('custom_js')
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            formData = {
                "previous_post_id": 2,
                "host_id": 3,
                "result": "OK",
            },
            url = base_url + '/packaging';

        function printBoxTicket(box_ticket) {
            //serial_numbers = box_ticket.serial_numbers
            var sn = '';
            box_ticket.serial_numbers.forEach(element => {
                sn += `<p>${element}</p>`
            })
            $('#qr_code').html('');
            const pElement = document.getElementById("qr_code");
            var qr = new QRCode(pElement, {
                text: box_ticket.info.box_qr,
                width: 50,
                height: 50,
            });
            var canvas = $('#qr_code canvas');
            console.log(canvas);
            var img = canvas.get(0).toDataURL("image/png");
            var newWin = window.open('', 'PRINT', 'height=700,width=1200');
            newWin.document.write(`<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            size: "a6";
            margin: 0px;
        }
        .flex-container {
            display: flex;
        }
        .flex-between {
            display: flex;
            justify-content: space-between;
            padding-inline: 10px;
        }
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        tr {
            padding-top: 1px;
            padding-bottom: 1px;
        }
        p {
            display: block;
            margin-block-start: 0.2em;
            margin-block-end: 0.2em;
            margin-inline-start: 0px;
            margin-inline-end: 0px;
        }
        .sn  p {
            padding: 3px;
            border: 1px solid grey;
            border-radius: 10px;
        }
    </style>
</head>
<body >
        <div class="company-header">
            <div class="flex-container">
                <img src="${box_ticket.info.logo}" alt="Company Logo">
                <div style="margin-inline: auto">
                    <h3>${box_ticket.info.name}</h3>
                    <p style="text-align:center"> ${box_ticket.info.name} </p>
                </div>
            </div>
        </div>
        <hr />
        <div class="flex-between">
            <p>Nom de produit</p>
            <h3>${box_ticket.info.product}</h3>
            <p>اسم المنتج</p>
        </div>
        <table width="100%">
            <tr>
                <th style="width:90%;">
                        <span style="font-size:12px">CARTON N°</span>
                        <span style="font-size:12px">${box_ticket.info.box_qr}</span>
                        <span style="font-size:12px">رقم التعليب</span>
                </th>
                <th style="width:15%">
                    <img src="${img}" style="padding:10px"/>
                    </th>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="flex-between">
                        <p>N° DE SERIE</p>
                        <p>الارقام التسلسلية</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="flex-between sn">
                        ${sn}
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="flex-between" style="margin: 0px">
                        <p>${box_ticket.info.boxed_date}</p>
                        <p style="border-inline-start:1px solid; padding-inline-start: 5px"> Qté ${box_ticket.info.box_quantity} الكمية</p>
                    </div>
                </td>
            </tr>
        </table>
</body>
</html>
`);
            newWin.document.close();
            // Wait for the new window to load the content
            newWin.onload = function() {
                newWin.print();
                newWin.close();
            };

        };
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
        }).on('click', '#print', function(e) {
            e.preventDefault();
            var box_ticket = {
                "serial_numbers": [
                    "001"
                ],
                "info": {
                    "id": 1,
                    "name": "UFMEEG",
                    "address": "Route Batna",
                    "email": "ufmeeg@enamc.dz",
                    "phone": "0773142654",
                    "fax": "036480012",
                    "logo": null,
                    "box_qr": "932810149003-35",
                    "boxed_date": "2023-08-03T13:07:01.000000Z",
                    "box_quantity": 1,
                    "product": "Gia Sporer In."
                }
            }
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
                    dataSrc: function(response) {
                        if (response.status == true) {
                            if (response.message !== "") {
                                ajaxSuccess(response.message)
                            }
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
                            if (response.data.box_ticket != undefined)
                                printBoxTicket(response.data.box_ticket)
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
