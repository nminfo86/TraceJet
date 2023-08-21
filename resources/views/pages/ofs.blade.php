@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('OFs') }}</li>
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
                        <h4 class="card-title text-capitalize">{{ __('liste des Ofs') }}</h4>
                        <div class="text-end  toggle-show">
                            @can('ofs-create')
                                @include('components.add_btn', ['label' => 'Nouveau'])
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('code') }}</th>
                                    <th>{{ __('n° Of') }}</th>
                                    <th>{{ __('quantité') }}</th>
                                    <th>{{ __('calibres') }}</th>
                                    <th>{{ __('statu') }}</th>
                                    <th>{{ __('options') }}</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
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
                        <div class="row text-capitalize">
                            <div class="col-lg-12">
                                <label>{{ __('produit') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="product_id" class="" name="product_id"
                                        data-placeholder="{{ __('Selectionner un produit') }}">
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
                                        data-placeholder="{{ __('selectionner un calibre') }}" name="caliber_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="caliber_id-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('qté OF') }}:*</label>
                                <input type="number" name="quantity" id="quantity" class="form-control"
                                    placeholder="{{ __('qté intiale') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="quantity-error"></strong>
                                </span>
                            </div>

                            <div class="col-lg-6">
                                <label>{{ __('statu') }}:*</label>

                                <select id="status" disabled name="status"
                                    data-placeholder="{{ __('selectionner un statu') }}">
                                    <option></option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="status-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label for="new_quantity">{{ __('qté globale d\'OF') }}</label>
                                <input type="number" id="new_quantity" name="new_quantity" class="form-control"
                                    placeholder="{{ __('qté globale d\'OF') }}" disabled>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="new_quantity-error"></strong>
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
            form_title = "{{ __('nouvel OF') }} ",
            url = base_url + '/ofs';

        formToggle(form_title);
        $(document).on('click', "#add_btn", (e) => {
            $('#status,#new_quantity').prop('disabled', true);
            // $('#new_quantity').prop('disabled', true);
        });
        $(document).ready(function() {

            /*----------------------get products list ---------------------------*/
            callAjax("GET", base_url + '/pluck/products', data = {
                filter: "hasCal"
            }).done(function(response) {
                appendToSelect(response.data, "#product_id")
            })
            /*----------------- Get of status list (Enum) --------------------*/
            callAjax('GET', base_url + '/of_status').done(function(response) {
                let opt = ``;
                $.each(response, function(key, val) {
                    opt += ` <option value=${key}>${val} </option>`;
                });
                $('#status').append(opt);
            });
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            storObject(url, formData, id, "{{ __('Of ajouté avec succès') }}",
                "{{ __('Of modifié avec succès') }}");
        });

        var caliber_id = 0;
        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', "#add_btn", (e) => {
            // form.find(".row").last().html("klklk");
            $(".status").remove();
            $('#quantity').prop('disabled', false);
        }).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            $('#status, #new_quantity').prop('disabled', false);
            $('#quantity').prop('disabled', true);
            form_title = " {{ __('Modification OF') }}";

            /* ------------------------------ Get Of values ----------------------------- */
            callAjax('GET', url + '/' + id).done(function(response) {
                $(".toggle-show").toggleClass('d-none');
                $("#product_id").val(response.data.caliber.product_id).trigger('change');
                $('#status').val(response.data.status).trigger('change');
                $('#quantity').val(response.data.quantity);
                $('#caliber_id').val(response.data.caliber_id).trigger('change');
                $('#new_quantity').val(response.data.new_quantity);
                $('#title').text(form_title);
            });
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
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
            }, false).done(function(response) {
                $("#caliber_id").html('<option></option>').trigger('change')
                appendToSelect(response.data, "#caliber_id");
            });
        });

        table = table.DataTable({
            "ajax": ajaxCallDatatables(url),
            columns: [{
                    data: 'of_code'
                },
                {
                    data: 'of_number'
                },
                {
                    data: 'new_quantity'
                },
                {
                    data: 'caliber_name'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
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
                        return `@can('of-edit') <div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div> @endcan
                        @can('of-delete') <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div> @endcan
                        @can('of-list') <a type="button" href="{{ asset('of_statistics/${data}') }}" class="d-inline pl-3 text-white historic"><i class="fa fa-eye text-info"></i> </div> @endcan`;
                    }
                },
            ],


        });
    </script>
@endpush
