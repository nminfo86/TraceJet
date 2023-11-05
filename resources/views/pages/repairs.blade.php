<!DOCTYPE html>
<html @if (Config::get('app.locale') == 'ar') dir="rtl" @endif lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body style="background-color: red !important">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="horizontal" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="min-height: 100vh">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div style="position:fixed;top:0;right:0;z-index:1000">
                    <span> <button class="btn btn-info btn-circle me-2 mt-2 text-white pt-1" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ LaravelLocalization::getCurrentLocale() }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a class="ms-2" rel="alternate" hreflang="{{ $localeCode }}"
                                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </span>
                    <span>
                        <a class="btn btn-danger btn-circle me-2 mt-2 text-white pt-1" href="{{ url('logout') }}">
                            <i class="fa fa-sign-out-alt text-white mt-1 fs-4"></i>
                        </a>
                    </span>
                </div>
                <div class="row d-flex align-items-stretch">
                    <div class="col-lg-6 flex-fill">
                        <div class="row">
                            {{-- Packaging --}}
                            <div class="col-12">
                                <div class="card shadow border-primary">
                                    <div class="card-body">
                                        <div class=" row">
                                            <form id="main_form">
                                                <div class="row mx-0">
                                                    <label for="inputPassword" class="col-md-1 "><i
                                                            class="mdi mdi-24px mdi-barcode-scan"></i></label>
                                                    <div class="col-md-11">
                                                        <input type="text" class="form-control bg-light"
                                                            id="qr" name="qr" onblur="this.focus()"
                                                            autofocus>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong id="qr-error"></strong>
                                                        </span>
                                                        <div class="text-center h4 pt-2" id="scanned_qr">
                                                            {{ __('Scanner un produit') }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="submit" class="d-none">
                                            </form>
                                            <hr class="mt-2" />
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-12 border-start border-secondary mx-auto mb-4 ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('OF Numéro') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-info ms-2 informations_qr"
                                                        id="of_number"> </span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('N° de serie') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-info ms-2 informations_qr"
                                                        id="serial_number"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('dernier NOK poste') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-info ms-2 informations_qr"
                                                        id="nok_post"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6  mt-4 ">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('Nom de produit') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-info ms-2 informations_qr"
                                                        id="product_name"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6  mt-4 ">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('Nom de calibre') }}</h6>
                                                    <span class="fs-1 font-weight-medium text-info ms-2 informations_qr"
                                                        id="caliber_name"></span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 flex-fill of_info">
                        <div class="card shadow border-primary" style="min-height: 90vh">
                            <div class="card-body text-white">
                                <div class="table-responsive">
                                    <table id="main_table" class="table table-sm table-hover  " width="100%">
                                        <thead class="bg-light">
                                            <tr>
                                                <td>SN</td>
                                                <td>Etat</td>
                                                <td>Created At</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- footer -->
                <!-- ============================================================== -->
                <div class="row ">
                    <div class="d-flex justify-content-between fixed-bottom bg-cyan  text-white pb-1 z-index-100 fs-4 ">
                        <div style="/*position:fixed;bottom:2%;left:1%;z-index:1000*/">
                            <span class="">{{ Auth::user()->username }} </span>
                        </div>
                        <div style="/*position:fixed;bottom:2%;right:2%;z-index:1000*/">
                            {{-- <span class="  ">{{ Session::get('user_data')['post_information']['post_name'] }}</span> --}}
                            <span class="">{{ Session::get('post_information')['post_name'] ?? '' }}
                            </span>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End footer -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
        </div>
        <div id="qr_code"></div>

        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
</body>
{{-- <script src="{{ asset('/dist/js/chart/chart.min.js') }}"></script> --}}
@include('layouts.script')
{{-- @push('custom_js') --}}
{{-- <script src="{{ asset('dist/js/pages/posts.js') }}"></script> --}}
<script type="text/javascript">
    var form = $('#main_form'),
        table = $('#main_table'),
        url = base_url + '/repairs',
        of_id,
        formData = {};
    /* -------------------------------------------------------------------------- */
    /*                               Get OF information                           */
    /* -------------------------------------------------------------------------- */
    var total_quantity_of = 0;
    var percent = 0;
    var newPercent = 0;
    var scanned_qr = 0;

    $(document).ready(function() {

        /* -------------------------------------------------------------------------- */
        /*                                get ofs list                                */
        /* -------------------------------------------------------------------------- */

    });
    /* -------------------------------------------------------------------------- */
    /*                                Valid Product                               */
    /* -------------------------------------------------------------------------- */
    $('#main_form').on('submit', function(e) {
        e.preventDefault();
        // alert();
        // return false;
        cleanValidationAlert();
        let qr = $("#qr").val();
        if (scanned_qr != 0) {

            if (scanned_qr == qr) {
                formData.result = "OK";
                formData.qr = qr;
                storeQr(formData);
            } else {
                if (qr == "0000") {
                    formData.result = "NOK";
                    formData.qr = scanned_qr;
                    storeQr(formData);
                } else {
                    getQr(formData, qr);
                }
            }
        } else {
            getQr(formData, qr);
        }
    });


    // function getSnTable(of_id) {
    //     // getOfDetails(of_id);
    //     postesDatatables(url, {
    //         "of_id": of_id
    //     }).done(function(response) {
    //         // if (response.message !== "") {
    //         // ajaxSuccess(response.message);
    //         // }
    //         $.each(response.data, function(key, value) {
    //             if (key == "of_ok") {
    //                 // alert(key);
    //                 $("#" + key).text(value + ' /' + total_quantity_of);
    //             } else
    //                 // alert(value)
    //                 $("#" + key).text(value);
    //         });

    //         buildChart(response.data.of_ok, total_quantity_of, ["{{ __('  réalisé') }}",
    //             "{{ __('  à réaliser') }}"
    //         ]);

    //         buildTable(response.data.list);


    //     });
    // }

    function getQr(formData, qr) {
        callAjax("GET", url + '/' + encodeURIComponent(qr)).done(function(response) {
            $("#qr").val("");
            ajaxSuccess(response.message);
            $("#scanned_qr").html(
                `<div class="alert alert-success"><span class="font-weight-bolder h4"> vous pouvez intervenir sur le produit : ${response.data.serial_number}</span></div>`
            );
            $.each(response.data, function(k, v) {
                $("#" + k).text(v);
            });
            scanned_qr = qr;
        });
    }

    table = table.DataTable({
        "ajax": ajaxCallDatatables(url),
        columns: [{
                data: 'serial_number'
            },
            {
                data: "result",
                render: function(data) {
                    if (data == "NOK") {
                        return `<label class="badge bg-danger">${data}</label>`;
                    } else return `<label class="badge bg-success">OK</label>`;
                },
            },
            {
                data: 'updated_at',
            }
        ],
    });

    function storeQr(formData) {
        callAjax("POST", url, formData).done(function(response) {
            //getSnTable(of_id);
            ajaxSuccess(response.message);
            $('#qr').val('');
            $('.informations_qr').text('');
            table.ajax.reload();
            scanned_qr = 0;
            $("#scanned_qr").html(`<strong class="h4"> Scanner un autre QR </strong>`);
        });
    }
</script>
{{-- @endpush --}}



</html>
