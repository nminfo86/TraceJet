@extends('layouts.posts_layout')
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->

    <div class="row h-100">
        <div class="col-lg-6">
            <div class="row h-100">
                <div class="col-12">
                    <div class="card border-primary bg-light">
                        <div class="card-body">
                            <div class="d-flex">
                                <form action="">
                                    <div class="d-flex w-50">
                                        <label for="inputPassword"><i class="mdi mdi-24px mdi-barcode-scan me-3"></i></label>
                                        <input type="text" class="form-control w-100" id="qr" name="qr"
                                            onblur="this.focus()" autofocus placeholder="Scanner un code QR">
                                        <span class="invalid-feedback" role="alert">
                                            <strong id="qr-error"></strong>
                                        </span>
                                        <input type="submit" class="d-none">
                                    </div>
                                </form>
                                {{-- <div class="d-flex justify-content-between"> --}}
                                <div class="border-start border-muted ms-2 w-auto">
                                    <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('N° OF') }}</h6>
                                    <span class="fs-3 font-weight-medium text-info ms-2" id="of_code"></span>
                                </div>
                                <div class="border-start border-muted ms-auto">
                                    <h6 class="fw-normal text-muted mb-0 ms-2">{{ __('Etat OF') }}</h6>
                                    <span class="fs-3 font-weight-medium text-info ms-2" id="of_status"></span>
                                </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 h-75">
                    <div class="card border-primary  h-100">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="main_table" class="table table-sm table-hover dt-responsive nowrap "
                                    width="100%">
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
        {{-- <div class="col-md-6 h-auto">
            <div class="card border-primary bg-light">
                <div class="card-body">
                    <div class="text-danger"> Attention !! changement d'OF

                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-6">
            <div class="row h-100">
                <div class="col-12">
                    <div class="card border-primary bg-light">
                        <div class="card-body">
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
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card border-primary bg-light">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row border-bottom mt-4 gx-0 mx-0">
                                    <div class="col-4 pb-3 border-end">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('Date lancement') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="of_created_at"></span>
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
                                                                <span class="text-muted">Qté Carton emplallé</span>
                                                                <h3 class="mb-0 text-info" id="packaged_box"></h3>
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
                                                                <span class="text-muted">Qté Produit emplallé</span>
                                                                <h3 class="mb-0 text-info" id="packaged_product"></h3>
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
    </div>
    <!--==============================================================-->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection
@push('custom_js')
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            url = base_url + '/packaging';
        /* -------------------------------------------------------------------------- */
        /*                                Valid Product                               */
        /* -------------------------------------------------------------------------- */
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();
            var qr = $("#qr").val();
            getSnTable(qr);
        });


        function getSnTable(formData) {
            return table.DataTable({
                // "ajax": url,
                ajax: {
                    type: 'POST',
                    url: base_url + '/packaging',
                    data: {
                        qr: formData,
                        mac: "mac5",
                        result: "OK"
                    },
                    // dataType: "json",

                    dataSrc: function(response) {
                        $.each(response.data.info, function(k, v) {
                            $("#" + k).text(v);
                        });
                        // alert(response.data)
                        // $("#serial_number").text(response.data.serial_number);
                        // $("#of_created_at").text(response.data.of_created_at);
                        // $("#box_qr").text(response.data.box_qr);
                        // $("#box_quantity").text(response.data.box_quantity);
                        // $("#of_number").text(response.data.of_number);
                        // $("#of_status").text(response.data.of_status);
                        // $("#box_status").text(response.data.box_status);
                        // $("#product_name").text(response.data.product_name);
                        // $("#caliber_name").text(response.data.caliber_name);
                        // $("#qty_ok").text("0" + response.data.sn_list.length + " / 0" +
                        //     response.data.quantity);
                        // $(".of_number").removeClass('d-none').find('#of_number').text("0" +
                        //     response
                        //     .data
                        //     .of_number);

                        // $(".of_info").removeClass("d-none");
                        $("#qr").focus();
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
                // rowCallback: function(row, data) {
                //     $(row).css('background-color', 'rgba(203, 239, 179, 0.8)');
                // },
                destroy: true,
                columnDefs: [{
                    targets: -1,
                }, ],
                // order: [0, "desc"]
            });

        }
    </script>
@endpush
