@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active text-capitalize" aria-current="page">{{ __('calibres') }}</li>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row toggle-show">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title">{{ __('List des calibres') }}</h4>
                        <div class="text-end upgrade-btn toggle-show">
                            @include('components.add_btn', ['label' => 'Nouveau'])
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('calibre') }}</th>
                                    <th>{{ __('Produit') }}</th>
                                    <th>{{ __('Quantité carton') }}</th>
                                    <th>{{ __('Options') }}</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <table class="d-none toggle-show w-100" style="height: calc(100vh - 700px);">
        <tbody>
            <td class="align-middle">

            </td>
        </tbody>
    </table> --}}
    <div class="d-flex justify-content-center toggle-show d-none">
        <div class="w-50">
            <div class="card">
                <div class="card-header bg-info">
                    <div class="d-flex justify-content-between">
                        <div class="text-white form-title" id="title"></div>
                        <div>
                            <div type="button" class=" text-white close-btn"><i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- //TODO::Add products input --}}
                <form id="main_form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Code') }}:*</label>
                                <input type="text" name="caliber_code" id="caliber_code" class="form-control"
                                    placeholder="{{ __('Code') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="caliber_code-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Calibre') }}:*</label>
                                <input type="text" name="caliber_name" id="caliber_name" class="form-control"
                                    placeholder="{{ __('Calibre') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="caliber_name-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Produit') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="product_id" class=""
                                        data-placeholder="{{ __('Selectionner un produit') }}" name="product_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="product_id-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Quantité par carton') }}:*</label>
                                <input type="number" name="box_quantity" id="box_quantity" class="form-control"
                                    placeholder="{{ __('Quantité par carton') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="box_quantity-error"></strong>
                                </span>
                            </div>
                        </div>
                    </div>
                    @include('components.footer_form')
                </form>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection
@push('custom_js')
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            form_title = " {{ __('Nouveau Calibre') }}",
            url = base_url + '/calibers';

        formToggle(form_title);

        $(document).ready(function() {
            /*----------------------get sections list ---------------------------*/
            callAjax('GET', base_url + '/pluck/products').done(function(response) {
                appendToSelect(response.data, "#product_id");
            });
            //alert(url);
            /*-----------------------intialize select fields ------------------------*/
            //customSelect2("fr");
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            storObject(url, formData, id
                /*, "{{ __('Calibre ajouté avec succès') }}",
                                "{{ __('Calibre modifié avec succès') }}"*/
            );
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification Calibre') }}";
            editObject(url + '/' + id, form_title);
            /*----------------- checkbox value set --------------------*/
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            /* ----------------- Fire alert to user about delete warning ---------------- */
            Dialog("{{ __('Confirmer la suppression') }}", "{{ __('Confirmer') }}", "{{ __('Fermer') }}").then((
                result) => {
                /* ---------- if he confirme deleting modal we start delete action ---------- */
                if (result.isConfirmed) {
                    deleteObject(url + '/' + id, "{{ __('Calibre supprimé') }}",
                        "{{ __('Suppression impossible') }}");
                }
            });
        });

        table = table.DataTable({
            "ajax": ajaxCallDatatables(url),
            columns: [{
                    data: 'caliber_code'
                },
                {
                    data: 'caliber_name'
                },
                {
                    data: 'product_name'
                },
                {
                    data: 'box_quantity'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                    <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div>`;
                    }
                },
            ]
        });
    </script>
@endpush
