@extends('layouts.app')

@section('content')
    <div class="toggle-show">
        <div class="container-fluid py-4">
            <button class="btn btn-primary" id="add_btn"><i class="fas fa-plus"></i></button>
        </div>
        {{-- @include('layouts.delete_modal') --}}
        <div class=" mt-2 container">
            <table id="main_table" class="table table-striped   dt-responsive nowrap " width="100%">
                <thead class="">
                    <tr class="">
                        {{-- <th>#</th> --}}
                        <th>{{ __('Nom d\'utilisateur') }}</th>
                        <th>{{ __('section') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('opt') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!-- form start -->
    <table class="d-none toggle-show w-100" style="height: calc(100vh - 80px);">
        <tbody>
            <td class="align-middle">
                <div class="d-flex justify-content-center">
                    <div class=" d-flex w-50">
                        <div class="card">
                            <div class="card-header bg-primary">
                                <div class="d-flex justify-content-between">
                                    <div class="text-white form-title"></div>
                                    <div>
                                        <div type="button" class=" text-white closebtn"><i class="fas fa-times"></i>
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
                                                <strong id="name-error"></strong>
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
                                            <input type="password" name="confirmPassword" id="confirmPassword"
                                                class="form-control" placeholder="{{ __('Confirmer le mot de passe') }}" />
                                            <span class="invalid-feedback" role="alert">
                                                <strong id="confirmPassword-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>{{ __('Rôle') }}:*</label>
                                            <select id="role" class="form-control select2" name="role">
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                <strong id="role-error"></strong>
                                            </span>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>{{ __('Section') }}:*</label>
                                            <select id="section" class="form-control select2" name="section">
                                            </select>
                                            <span class="invalid-feedback" role="alert">
                                                <strong id="section-error"></strong>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer float-right">
                                    <button type="submit" class="btn btn-success h6 px-3 py-2"> <i class="fa fa-save"></i>
                                        {{ __('Confirmer') }}</button>
                                    <button type="button" id="close-btn" class="btn btn-danger close-btn h6 py-2 px-3"><i
                                            class="fa fa-times"></i>
                                        <span class="pe-2"> {{ __('Fermer') }} </span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </td>
        </tbody>
    </table>

    {{-- <table style="height: calc(100vh - 50px);">


                    <td class="align-middle">middle</td>

                </tr>
            </tbody>
        </table> --}}
    <!-- form ends -->
@endsection
@push('custom_js')
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            form_title = " {{ __('student') }}",
            url = 'api/v1/users';



        $(document).ready(function() {
            $.ajax({
                url: 'api/v1/pluck/roles',
                type: "GET",
                dataType: ajaxDataType,
                success: function(response) {
                    $.each(response.data, function(key, val) {
                        $('#role').append(
                            '<option value=' + key + '>' + val +
                            '</option>'
                        )
                    });
                },
                error: function(jqXHR, exception) {
                    showAjaxAndValidationErrors(jqXHR, exception);
                }
            });
            $.ajax({
                url: 'api/v1/pluck/sections',
                type: "GET",
                dataType: ajaxDataType,
                success: function(response) {
                    $.each(response.data, function(key, val) {
                        $('#section').append(
                            '<option value=' + key + '>' + val +
                            '</option>'
                        )
                    });
                },
                error: function(jqXHR, exception) {
                    showAjaxAndValidationErrors(jqXHR, exception);
                }
            });
        });
        formToggle(form, true);
        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            storObject(url, formData, id);
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            editObject(url + '/' + id, form_title, true)
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            //Fire alert to user about delete warning
            Dialog("{{ __('labels.title-confirme') }}").then((result) => {
                // if he confirme deleting modal we start delete action
                if (result.isConfirmed) {
                    deleteObject(url + '/' + id);
                }
            });
        });

        table.dataTable({
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
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                        <div type="button" id = ${data} class="d-inline pl-3 text-white delete" data-bs-toggle="modal"
                        data-bs-target="#confirmDelete"><i class="fas fa-trash text-danger"></i> </div>`;
                    }
                },
            ],
        });
    </script>
@endpush
