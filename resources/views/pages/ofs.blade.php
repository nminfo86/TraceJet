@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Ofs') }}</li>
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
                    <h4 class="card-title">{{ __('Liste des Ofs') }}</h4>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('N° Of') }}</th>
                                    <th>{{ __('Quantity') }}</th>
                                    <th>{{ __('Calibres') }}</th>
                                    <th>{{ __('Status') }}</th>
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
                            <div class="col-lg-12">
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
                            <div class="col-lg-8">
                                <label>{{ __('Calibre') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="caliber_id" class=""
                                        data-placeholder="{{ __('Selectionner un calibre') }}" name="caliber_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="caliber_id-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('OF Quantité') }}:*</label>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    placeholder="{{ __('Quantité') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="quantity-error"></strong>
                                </span>
                            </div>
                            {{-- //TODO::nassim add staus of calibre --}}
                            {{-- <div class="col-lg-12 status">
                                <label>{{ __('Status') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="status" class=""
                                        data-placeholder="{{ __('Selectionner un status') }}">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="status-error"></strong>
                                    </span>
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
            form_title = " {{ __('Nouveau Of') }}",
            url = base_url + '/ofs';

        formToggle(form_title);

        $(document).ready(function() {

            /*----------------------get products list ---------------------------*/
            callAjax('GET', base_url + '/pluck/products', {
                filter: "hasCal"
            }).done(function(response) {
                appendToSelect(response.data, "#product_id");
            });
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            storObject(url, formData, id, "{{ __('Of ajouté avec succès') }}",
                "{{ __('Of modifié avec succès') }}");
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', "#add_btn", (e) => {
            // form.find(".row").last().html("klklk");
            $(".status").remove();
        }).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification Of') }}";

            /*----------------- Get of status list (Enum) --------------------*/
            callAjax('GET', base_url + '/of_status').done(function(response) {

                let opt = ``;
                $.each(response, function(key, val) {
                    opt += ` <option value=${key}>${val} </option>`;
                });

                let select = `<div class="col-lg-12 status">
                        <label>{{ __('Status') }}:*</label>

                            <select id="status" name="status"
                                data-placeholder="{{ __('Selectionner un status') }}">
                                <option></option>
                                ${opt}
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong id="status-error"></strong>
                            </span>
                        </div>`;
                $('select').trigger('change');

                form.find('.row').append(select);
            });

            /* ------------------------------ Get Of values ----------------------------- */
            callAjax('GET', url + '/' + id).done(function(response) {
                $(".toggle-show").toggleClass('d-none');
                $.each(response.data, function(key, val) {
                    $('#' + key).val(val);
                });
                $('select').trigger('change');
                $('#title').text(form_title);
            });
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            alert(id);
            /* ----------------- Fire alert to user about delete warning ---------------- */
            Dialog("{{ __('Confirmer la suppression') }}", "{{ __('Confirmer') }}", "{{ __('Fermer') }}").then((
                result) => {
                /* ---------- if he confirme deleting modal we start delete action ---------- */
                if (result.isConfirmed) {
                    deleteObject(url + '/' + id, "{{ __('Of supprimé') }}",
                        "{{ __('Suppression impossible') }}");
                }
            });
        }).

        on("change", "#product_id", function(e) {
            e.preventDefault();
            let id = $(this).val();
            // alert(id);
            /*----------------------get calibers list ---------------------------*/
            callAjax('GET', base_url + '/pluck/calibers', {
                filter: id
            }).done(function(response) {
                $("#caliber_id").html('<option></option>').trigger('change')
                appendToSelect(response.data, "#caliber_id");
            });

        });

        table = table.DataTable({
            "ajax": url,
            columns: [{
                    data: 'of_code'
                },
                {
                    data: 'of_number'
                },
                {
                    data: 'quantity'
                },
                {
                    data: 'caliber_name'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        // return data == 1 ?
                        //     `<label class="badge bg-success">${yes}</label>` :
                        //     `<label class="badge bg-danger">${no}</label>`;
                        switch (data) {
                            case "inProd":
                                return `<label class="badge bg-primary">inProduction</label>`;
                                break;
                            case "new":
                                return `<label class="badge bg-info">Vide</label>`;
                                break;
                            case "closed":
                                return `<label class="badge bg-success">Fermé</label>`;
                                break;
                            case "posed":
                                return `<label class="badge bg-warning">Pause</label>`;
                                break;
                                // default:
                                //     break;
                        }
                    }
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                    <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div>`;
                    }
                },
            ],
            // TODO::SAmir table ordring probleme
            // order: false

        });
    </script>
@endpush
