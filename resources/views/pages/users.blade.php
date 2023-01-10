@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Administration') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Utilisateurs') }}</li>
@endsection
@section('btns_actions')
    <div class="text-end upgrade-btn toggle-show">
        {{-- <a href="https://www.wrappixel.com/templates/flexy-bootstrap-admin-template/" class="btn btn-primary text-white"
            target="_blank">Upgrade to Pro</a> --}}
        <button class="btn btn-primary" id="add_btn">{{ __('nouvel utilisateur') }}</button>
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
                        <table id="main_table" class="table  dt-responsive nowrap " width="100%">
                            <thead class="">
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('Nom d\'utilisateur') }}</th>
                                    <th>{{ __('Section') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('acitve') }}</th>
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
        <div class=" d-flex w-50">
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
                                <select id="roles_name" class="form-control select2" name="roles_name">
                                </select>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="roles_name-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('Section') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="section_id" class="select2"
                                        placeholder="{{ __('Selectionner une section') }}" name="section_id">
                                        <option></option>
                                    </select>
                                    <button class="input-group-text btn btn-success" id="basic-addon2"><i
                                            class="fa fa-plus"></i></button>
                                </div>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="section_id-error"></strong>
                                </span>
                            </div>
                            <div class="col-12 pt-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" checked value="1"
                                        role="switch" id="flexSwitchCheckDefault">
                                    <label class="form-check-label"
                                        for="flexSwitchCheckDefault">{{ __('Etat d\'utilisateur actif') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer float-right">
                        <button type="submit" class="btn btn-success text-white h6 px-3 py-2"> <i class="fa fa-save"></i>
                            {{ __('Confirmer') }}</button>
                        <button type="button" id="close-btn" class="btn btn-danger text-white close-btn h6 py-2 px-3"><i
                                class="fa fa-times"></i>
                            <span class="pe-2"> {{ __('Fermer') }} </span></button>
                    </div>
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
            callAjax('GET', 'api/v1/pluck/roles', {}).done(function(response) {
                $.each(response.data, function(key, val) {
                    $('#roles_name').append(
                        '<option value=' + val + '>' + val +
                        '</option>'
                    )
                });
            });

            /*----------------------get sections list ---------------------------*/
            callAjax('GET', 'api/v1/pluck/sections', {}).done(function(response) {
                $.each(response.data, function(key, val) {
                    $('#section_id').append(
                        '<option value=' + key + '>' + val +
                        '</option>'
                    )
                });
            });
            $('#section_id').select2({
                theme: "bootstrap-5",
                width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' :
                    'style',
                placeholder: $(this).data('placeholder'),
            });
        });
        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            storObject(url, formData, id, "{{ __('Utilisateur ajouté avec succès') }}",
                "{{ __('Utilisateur modifié avec succès') }}");
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification Utilisateur') }}";
            editObject(url + '/' + id, form_title);
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            //Fire alert to user about delete warning
            Dialog("{{ __('Confirmer la suppression') }}", "{{ __('Confirmer') }}", "{{ __('Fermer') }}").then((
                result) => {
                // if he confirme deleting modal we start delete action
                if (result.isConfirmed) {
                    deleteObject(url + '/' + id, "{{ __('Utilisateur supprimé') }}",
                        "{{ __('suppression impossible') }}");
                }
            });
        });

        var yes = "{{ __('Oui') }}";
        var no = "{{ __('Non') }}";
        table = table.DataTable({
            "ajax": url,
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
            ],
        });
    </script>
@endpush
