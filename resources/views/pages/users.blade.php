@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Administration') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Utilisateurs') }}</li>
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
                    <h4 class="card-title">{{ __('Liste des utilisateurs') }}</h4>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('Nom d\'utilisateur') }}</th>
                                    <th>{{ __('Section') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Actif') }}</th>
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
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Nom') }}:*</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="{{ __('Nom et prénom') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="name-error">dd</strong>
                                </span>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('Nom d\'utilisateur') }}:*</label>
                                <input type="text" name="username" id="username" class="form-control"
                                    placeholder="{{ __('Nom d\'utilisateur') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="username-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Mot de passe') }}:*</label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="{{ __('Mot de passe') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="password-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Confirmer le mot de passe') }}:*</label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control" placeholder="{{ __('Confirmer le mot de passe') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="password_confirmation-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Rôle') }}:*</label>
                                <select id="roles_name" class="form-control select2"
                                    data-placeholder="{{ __('Selection un role') }}" name="roles_name">
                                    <option></option>
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="roles_name-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6">
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
                            <div class="col-12 pt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" role="switch"
                                        value="1" checked>
                                    <label class="form-check-label" for="status">{{ __('Etat d\'utilisateur actif') }}
                                    </label>
                                </div>

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
            form_title = " {{ __('Nouvel Utilisateur') }}",
            url = 'api/v1/users';
        formToggle(form_title);

        $(document).ready(function() {
            /*--------------------- get role list ------------------------*/
            appendToSelect('GET', base_url + '/pluck/roles', "#roles_name", {}, true);

            /*----------------------get sections list ---------------------------*/
            appendToSelect('GET', base_url + '/pluck/sections', "#section_id");


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
                    data: 'username'
                },
                {
                    data: 'section_name'
                }, {
                    data: 'roles_name'
                },
                {
                    data: 'status',
                    render: function(data, type, row) {
                        return data == 1 ?
                            `<label class="badge bg-success">${yes}</label>` :
                            `<label class="badge bg-danger">${no}</label>`;
                    }
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

        $(document).on('change', '.form-check-input', function(e) {
            if ($(this).is(':checked'))
                $(this).val(1);
            else
                $(this).val(0);
        });
    </script>
@endpush
