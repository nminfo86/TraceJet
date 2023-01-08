@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Administration') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Utilisateurs') }}</li>
@endsection
@section('btns_actions')
    <div class="text-end upgrade-btn">
        {{-- <a href="https://www.wrappixel.com/templates/flexy-bootstrap-admin-template/" class="btn btn-primary text-white"
            target="_blank">Upgrade to Pro</a> --}}
        <button class="btn btn-primary" id="btn-add">{{ __('nouvel utilisateur') }}</button>
    </div>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Liste des utilisateurs') }}</h4>
                    <div class="table-responsive">
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
