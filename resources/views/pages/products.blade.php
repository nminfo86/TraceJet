@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Produits') }}</li>
@endsection
@section('btns_actions')
    <div class="text-end upgrade-btn toggle-show">
        {{-- <a href="https://www.wrappixel.com/templates/flexy-bootstrap-admin-template/" class="btn btn-primary text-white"
            target="_blank">Upgrade to Pro</a> --}}
        @include('components.add_btn', ['label' => 'Nouveau'])
    </div>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row toggle-show">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Liste des produits') }}</h4>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Produit') }}</th>
                                    <th>{{ __('Section') }}</th>
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
                <form id="main_form">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Code') }}:*</label>
                                <input type="text" name="product_code" id="product_code" class="form-control"
                                    placeholder="{{ __('Code') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="product_code-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Produit') }}:*</label>
                                <input type="text" name="product_name" id="product_name" class="form-control"
                                    placeholder="{{ __('Produit') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="product_name-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-12">
                                <label>{{ __('Section') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="section_id" class=""
                                        data-placeholder="{{ __('Selectionner une section') }}" name="section_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="section_id-error"></strong>
                                    </span>
                                </div>
                            </div>
                            {{-- <div class="col-12 pt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" role="switch"
                                        value="1" checked>
                                    <label class="form-check-label" for="status">{{ __('Actif') }}
                                    </label>
                                </div>
                            </div> --}}
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
            form_title = " {{ __('Nouveau Produit') }}",
            url = base_url + '/products';

        formToggle(form_title);

        $(document).ready(function() {
            /*----------------------get sections list ---------------------------*/
            appendToSelect('GET', base_url + '/pluck/sections', "#section_id");

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
        });

        table = table.DataTable({
            "ajax": url,
            columns: [{
                    data: 'product_code'
                },
                {
                    data: 'product_name'
                }, {
                    data: 'section_name'
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
