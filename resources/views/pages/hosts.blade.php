@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Administration') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Posts') }}</li>
@endsection
{{-- @section('btns_actions')
@endsection --}}
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row toggle-show">
        <div class="col-5">
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
                        {{-- <div class="row"> --}}
                        <div class="form-row">
                            <label>{{ __('Nom') }}:*</label>
                            <input type="text" name="post_name" id="post_name" class="form-control"
                                placeholder="{{ __('Post name') }}" />
                            <span class="invalid-feedback" role="alert">
                                <strong id="post_name-error"> </strong>
                            </span>
                        </div>

                        <div class="form-row">
                            <label>{{ __('Type') }}:*</label>
                            <select id="post_type" class="form-control select2"
                                data-placeholder="{{ __('Selection un role') }}" name="post_type">
                                <option></option>
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong id="post_type-error"></strong>
                            </span>
                        </div>
                        <div class="form-row">
                            <label>{{ __('Previous post') }}:*</label>
                            <select id="previous_post_id" class="form-control select2"
                                data-placeholder="{{ __('Selection un role') }}" name="previous_post_id">
                                <option></option>
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong id="previous_post_id-error"></strong>
                            </span>
                        </div>

                        <div class=" form-row">
                            <label>{{ __('IP address') }}:*</label>
                            <input type="text" name="ip_adress" id="ip_adress" class="form-control"
                                placeholder="{{ __('IP address') }}" />
                            <span class="invalid-feedback" role="alert">
                                <strong id="ip_adress-error"></strong>
                            </span>
                        </div>

                        {{-- </div> --}}
                    </div>
                    @include('components.footer_form')
                </form>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title">{{ __('Liste des posts') }}</h4>
                    </div>

                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead class="bg-light">
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Previous') }}</th>
                                    <th>{{ __('IP') }}</th>
                                    <th>{{ __('Options') }}</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
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

        $(document).ready(function() {
            /*--------------------- get role list ------------------------*/
            // appendToSelect('GET', base_url + '/pluck/roles', "#roles_name", {}, true);

            callAjax('GET', base_url + '/pluck/posts').done(function(response) {
                appendToSelect(response.data, "#post_name");
            });

            /*----------------------get sections list ---------------------------*/
            // appendToSelect('GET', base_url + '/pluck/sections', "#section_id");
            callAjax('GET', base_url + '/pluck/sections').done(function(response) {
                appendToSelect(response.data, "#section_id");
            });
            /*-----------------------intialize select fields ------------------------*/
            //customSelect2("fr");
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("status", $("#status").val());
            storObject(url, formData, id, "{{ __('Utilisateur ajouté avec succès') }}",
                "{{ __('Utilisateur modifié avec succès') }}");
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification Utilisateur') }}";
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
                    deleteObject(url + '/' + id, "{{ __('Utilisateur supprimé') }}",
                        "{{ __('suppression impossible') }}");
                }
            });
        });

        table = table.DataTable({
            "ajax": ajaxCallDatatables(url),
            columns: [{
                    data: 'post_name'
                },
                {
                    data: 'posts_type_id'
                },
                {
                    data: 'previous_post_id'
                }, {
                    data: 'ip_address'
                },
                /*{
                    data: 'status',
                    render: function(data, type, row) {
                        return data == 1 ?
                            `<label class="badge bg-success">${yes}</label>` :
                            `<label class="badge bg-danger">${no}</label>`;
                    }
                },*/
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                    <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div>`;
                    }
                },
            ]
        });

        $(document).on('change', '.form-check-input', function(e) {
            if ($(this).is(':checked'))
                $(this).val(1);
            else
                $(this).val(0);
        });
    </script>
@endpush
