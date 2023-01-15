@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item" aria-current="page">{{ __('Administration') }}</li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Rôles') }}</li>
@endsection
@section('btns_actions')
    <div class="text-end upgrade-btn toggle-show">
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
                    <h4 class="card-title">{{ __('Liste des rôles') }}</h4>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th width="90%">{{ __('Rôle') }}</th>
                                    <th>{{ __('Options') }}</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="justify-content-center toggle-show d-none">
        <div class="">
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
                            <div class="col-12 mb-2">
                                <label>{{ __('Nom') }}:*</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="{{ __('Nom de rôle') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="name-error">dd</strong>
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
            form_title = " {{ __('Nouveau Rôle') }}",
            url = 'api/v1/users';
        formToggle(form_title);

        $(document).ready(function() {
            /*--------------------- get role list ------------------------*/
            callAjax('GET', 'api/v1/pluck/permissions').done(function(response) {
                //appendToSelect(response.data, "#roles_name", true);
                //console.log(response.data);
                //return false;
                var oldPermission = Object.values(response.data)[0].split('-')[0];
                //console.log(oldPermission);
                var actions = new Map();
                $.each(response.data, function(indexInArray, valueOfElement) {
                    let permission = valueOfElement.split('-');
                    let newPermission = permission[1];
                    if (oldPermission == permission[0]) {
                        actions[indexInArray] = newPermission;
                    } else {
                        $.each(actions, function(index, value) {
                            console.log(index + ' => ' + value);
                        });
                        actions = {};
                        actions[indexInArray] = newPermission;
                    }
                    oldPermission = permission[0];
                });
            });

            // /*----------------------get sections list ---------------------------*/
            // callAjax('GET', 'api/v1/pluck/sections').done(function(response) {
            //     appendToSelect(response.data, "#section_id");
            // });

            /*-----------------------intialize select fields ------------------------*/
            //customSelect2("fr");
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            formData.append("status", $("#status").val());
            storObject(url, formData, id, "{{ __('Rôle ajouté avec succès') }}",
                "{{ __('Rôle modifié avec succès') }}");
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification de rôle') }}";
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
            Dialog("{{ __('Confirmer la suppression') }}", "{{ __('Confirmer') }}", "{{ __('Fermer') }}")
                .then((
                    result) => {
                    /* ---------- if he confirme deleting modal we start delete action ---------- */
                    if (result.isConfirmed) {
                        deleteObject(url + '/' + id, "{{ __('Rôle supprimé') }}",
                            "{{ __('suppression impossible') }}");
                    }
                });
        });

        table = table.DataTable({
            "ajax": url,
            columns: [{
                    data: 'name'
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
