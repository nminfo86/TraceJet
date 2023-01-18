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
                    <div class="card border-primary">
                        <div class="card-body">
                            {{-- <div class="col-lg-12"> --}}
                            <div class=" row">
                                <label for="inputPassword" class="col-md-1 col-form-label">OF N° </label>
                                <div class="col-md-4">
                                    <select id="of_id" data-placeholder="{{ __('Selectionner une of') }}"
                                        name="of_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="of_id-error"></strong>
                                    </span>
                                </div>
                                {{-- <div class="col-md-6 d-none of_number">
                                    <div class="row float-end"> --}}
                                {{-- <h6 class="fw-normal text-muted mb-0">{{ __('OF Numéro') }}</h6>
                                        <span class="fs-3 font-weight-medium text-info" id="of_number"></span> --}}
                                {{-- <div class="row border-bottom mt-4 gx-0"> --}}
                                <div class="col-md-6  of_number d-none ">
                                    <div class="col-4 pb-3 border-start float-end ">
                                        <h6 class="fw-normal text-muted mb-0">{{ __('OF Numéro') }}</h6>
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

                <div class="col-12 d-none of_info">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="row mx-0">
                                    <label for="inputPassword" class="col-md-1 "><i
                                            class="mdi mdi-24px mdi-barcode-scan"></i></label>
                                    <div class="col-md-11">
                                        <input type="text" class="form-control bg-light" id="qr" name="qr"
                                            onblur="this.focus()" autofocus>
                                        <span class="invalid-feedback" role="alert">
                                            <strong id="qr-error"></strong>
                                        </span>
                                    </div>
                                </div>


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
                                                                class=" round rounded-circle text-white d-inline-block text-center bg-danger">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-calendar feather-sm fill-white">
                                                                    <rect x="3" y="4" width="18"
                                                                        height="18" rx="2" ry="2">
                                                                    </rect>
                                                                    <line x1="16" y1="2" x2="16"
                                                                        y2="6"></line>
                                                                    <line x1="8" y1="2" x2="8"
                                                                        y2="6"></line>
                                                                    <line x1="3" y1="10" x2="21"
                                                                        y2="10"></line>
                                                                </svg>
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
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-calendar feather-sm fill-white">
                                                                    <rect x="3" y="4" width="18"
                                                                        height="18" rx="2" ry="2">
                                                                    </rect>
                                                                    <line x1="16" y1="2" x2="16"
                                                                        y2="6"></line>
                                                                    <line x1="8" y1="2" x2="8"
                                                                        y2="6"></line>
                                                                    <line x1="3" y1="10" x2="21"
                                                                        y2="10"></line>
                                                                </svg>
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
        <div class="col-lg-6 d-none of_info">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    <th>{{ __('serial_number') }}</th>
                                    <th>{{ __('QR') }}</th>
                                    <th>{{ __('Options') }}</th>
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
            url = base_url + '/serial_numbers';

        formToggle(form_title);

        $(document).ready(function() {
            /*----------------------get ofs list ---------------------------*/
            callAjax('GET', base_url + '/pluck/ofs').done(function(response) {
                appendToSelect(response.data, "#of_id");
            });
            callAjax('GET', base_url + '/of_status').done(function(response) {
                // appendToSelect(response.data, "#of_id");
                console.log(response);
            });
            //alert(url);
            /*-----------------------intialize select fields ------------------------*/
            //customSelect2("fr");
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            // formData.append("status", $("#status").val());
            storObject(url, formData, id, "{{ __('Produit ajouté avec succès') }}",
                "{{ __('Produit modifié avec succès') }}");
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification Produit') }}";
            editObject(url + '/' + id, form_title);
            /*----------------- checkbox value set --------------------*/
            if ($('#status').val() == 0)
                $('#status').prop('checked', false);
            else
                $('#status').prop('checked', true);
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            /* ----------------- Fire alert to user about delete warning ---------------- */
            Dialog("{{ __('Confirmer la suppression') }}", "{{ __('Confirmer') }}", "{{ __('Fermer') }}").then((
                result) => {
                /* ---------- if he confirme deleting modal we start delete action ---------- */
                if (result.isConfirmed) {
                    deleteObject(url + '/' + id, "{{ __('Produit supprimé') }}",
                        "{{ __('Suppression impossible') }}");
                }
            });
        }).on("change", "#of_id", function(e) {
            e.preventDefault()
            var of_id = $("#of_id").val();

            table.DataTable({
                // "ajax": url,
                ajax: {
                    type: 'GET',
                    url: url,
                    data: {
                        "of_id": of_id
                    },

                    dataSrc: function(response) {

                        $("#qty_ok").text("0" + response.data.sn_list.length);
                        $("#of_date").text(response.data.product_name);
                        $("#product").text(response.data.product_name);
                        $("#caliber").text(response.data.caliber_name);
                        $(".of_number").removeClass('d-none').find('#of_number').text("0" + response
                            .data
                            .of_number);

                        $(".of_info").removeClass("d-none");

                        return response.data.sn_list;

                    }
                },
                columns: [{
                        data: 'serial_number'
                    },
                    {
                        data: 'qr'
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `<div type="button" id="${data}" class="d-inline text-white print_qr"> <i class="mdi mdi-printer-settings text-primary"></i></div>
                    `;
                        }
                    },
                ],
                destroy: true,
            });

            // $(".main_table").removeClass("d-none");
        });
    </script>
@endpush
