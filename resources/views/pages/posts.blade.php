@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Postes') }}</li>
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
                        <h4 class="card-title">{{ __('Liste des postes') }}</h4>
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
                                    <th>{{ __('Nom de poste') }}</th>
                                    <th>{{ __('Type de poste') }}</th>
                                    <th>{{ __('Section') }}</th>
                                    <th>{{ __('Adrèsse IP') }}</th>
                                    <th>{{ __('Poste précédent') }}</th>
                                    <th>{{ __('Options') }}</th>
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
                        <div class="row">
                            <div class="col-lg-12">
                                <label>{{ __('Nom de section') }}:*</label>
                                <div class="input-group mb-3">
<<<<<<< HEAD
                                    <select id="section_id" name="section_id"
                                        data-placeholder="{{ __('Selectionner un section') }}">
=======
                                    <select id="section_id" class="" name="section_id"
                                        data-placeholder="{{ __('Selectionner une section') }}">
>>>>>>> fa3c6559cba32a7910608f6196b04e6498d02d6c
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="section_id-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('Code') }}:*</label>
                                <input type="text" name="code" id="code" class="form-control"
                                    placeholder="{{ __('Code') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="code-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-8">
                                <label>{{ __('Nom de post') }}:*</label>
                                <input type="text" name="post_name" id="post_name" class="form-control"
                                    placeholder="{{ __('Nom de post') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="post_name-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label>{{ __('Type') }}:*</label>
                                <select id="posts_type_id" name="posts_type_id"
                                    data-placeholder="{{ __('Selectionner un type') }}">
                                    <option></option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="posts_type_id-error"></strong>
                                </span>
                            </div>

                            <div class="col-lg-8">
                                <label for="ip_address">{{ __('IP address') }}</label>
                                <input type="number" id="ip_address" name="ip_address" class="form-control"
                                    placeholder="address IP">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="ip_address-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-12 d-none" id="d-previous-post">
                                <label>{{ __('Poste précédent') }}:*</label>
                                <select id="previous_post_id" name="previous_post_id"
                                    data-placeholder="{{ __('Selectionner un type') }}">
                                    <option></option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="previous_post_id-error"></strong>
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
            form_title = " {{ __('Nouveau Post') }}",
            url = base_url + '/posts';

        formToggle(form_title);
        // $(document).on('click', "#add_btn", (e) => {
        //     $('#status,#new_quantity').prop('disabled', true);
        //     // $('#new_quantity').prop('disabled', true);
        // });
        $(document).ready(function() {

            // /*----------------------get sections list ---------------------------*/
            callAjax("GET", base_url + '/pluck/sections').done(function(response) {
                appendToSelect(response.data, "#section_id")
            })
            // /*----------------- Get posts type list --------------------*/
            callAjax("GET", base_url + '/pluck/posts_types').done(function(response) {
                appendToSelect(response.data, "#posts_type_id")
            })
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            storObject(url, formData, id, "{{ __('Of ajouté avec succès') }}",
                "{{ __('Of modifié avec succès') }}");
        });

        $(document).on('change', "#section_id", (e) => {
            /*----------------- Get posts list --------------------*/
            callAjax("GET", base_url + '/pluck/posts', {
                section_id: 1
            }).done(function(response) {
                appendToSelect(response.data, "#previous_post_id");
                $("#d-previous-post").removeClass("d-none");
            })
        }).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            $('#status, #new_quantity').prop('disabled', false);
            $('#quantity').prop('disabled', true);
            form_title = " {{ __('Modification OF') }}";

            /* ------------------------------ Get Of values ----------------------------- */
            callAjax('GET', url + '/' + id).done(function(response) {
                $(".toggle-show").toggleClass('d-none');
<<<<<<< HEAD
                $("#product_id").val(response.data.caliber.product_id).trigger('change');
                $('#status').val(response.data.status).trigger('change');
                $('#quantity').val(response.data.quantity);
                $('#caliber_id').val(response.data.caliber_id).trigger('change');
                $('#new_quantity').val(response.data.new_quantity);
=======
                $("#section_id").val(response.data.section_id).trigger('change');
                $("#posts_type_id").val(response.data.posts_type_id).trigger('change');
                if (response.data.previous_post_id != null)
                    $("#previous_post_id").val(response.data.previous_post_id).trigger('change');
                else {

                }
                $('#post_name').val(response.data.post_name);
                $('#code').val(response.data.code);
                $('#ip_address').val(response.data.ip_address);
>>>>>>> fa3c6559cba32a7910608f6196b04e6498d02d6c
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
                    data: 'code'
                },
                {
                    data: 'post_name'
                },
                {
                    data: 'posts_type'
                },
                {
                    data: 'section_name'
                }, {
                    data: 'ip_address'
                },
                {
                    data: 'previous_post'
                },
                // {
                //     data: 'status',
                // },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                    <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div>
                    <div type="button" id = ${data} class="d-inline pl-3 text-white historic"><i class="fa fa-eye text-info"></i> </div>`;
                    }
                },
            ],
            // TODO::SAmir table ordring probleme
            // order: false

        });
    </script>
@endpush
