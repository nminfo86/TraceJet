@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item text-capitalize" aria-current="page">{{ __('administration') }}</li>
    <li class="breadcrumb-item active text-capitalize" aria-current="page">{{ __('rôles') }}</li>
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
                        <h4 class="card-title">{{ __('List des rôles') }}</h4>
                        <div class="text-end upgrade-btn toggle-show">

                            @include('components.add_btn', ['label' => 'Nouveau'])
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th width="90%" class="text-capitalize">{{ __('rôle') }}</th>
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
                        <div class="row" id="appendPermission">
                            <div class="col-12 mb-4">
                                <label class="text-capitalize">{{ __('nom') }}:*</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="{{ __('Nom de rôle') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="name-error"></strong>
                                </span>
                            </div>
                            <hr>
                            <div class="col-12 mb-4">
                                {{ __('Permissions') }}
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover" id="permissions_table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Pages') }}</th>
                                            <th>{{ __('Permissions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @include('components.footer_form')
                </form>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            form_title = " {{ __('Nouveau rôle') }}",
            url = 'api/v1/roles';
        formToggle(form_title);

        $(document).ready(function() {

            // Send an AJAX request to the server to get the permissions data
            $.ajax({
                    method: 'GET',
                    url: 'api/v1/pluck/permissions'
                })
                // When the response is received, execute the following function
                .done(function(response) {
                    // Store the response data in a variable
                    var data = response.data;

                    // Loop through each item in the data object
                    $.each(data, function(key, values) {
                        // Create a new row element
                        var row = $("<tr>");

                        // Create a new cell element for the page name and add the "text-capitalize" class
                        var page = $("<td>").addClass("text-capitalize").text(key);

                        // Create a new cell element for the actions
                        var actions = $("<td>");
                        var permission = `<div class='row'>
                            <div class=" col-12 col-md-5 form-check form-switch form-check-inline">
                <input class="form-check-input select-sup-permissions" type="checkbox"  role="switch">
                <label class="form-check-label ">{{ __('Sélectionner tout') }}</label></div>
                <div class="col-12 col-md-6">`;
                        // Loop through each item in the values array
                        $.each(values, function(index, value) {
                            // Create a new permission element using the permissionsList() function
                            permission += permissionsList(value[0], value[1]);

                        });
                        permission += "</div></div>";
                        // Append the permission element to the actions cell
                        actions.append(permission);

                        // Append the page and actions cells to the row element
                        row.append(page).append(actions);

                        // Append the row element to the table body
                        $("#permissions_table tbody").append(row);
                    });

                });


        });
        // select all sup permissions
        $(document).on('click', '.select-sup-permissions', function(e) {
            //e.preventDefault()
            var nextDiv = $(this).parent().next();
            //console.log(nextDiv);
            // loop through each input element within the next div
            if ($(this).prop("checked")) {
                nextDiv.find("input").each(function() {
                    // do something with each input element here
                    //console.log($(this).val());
                    $('#appendPermission #' + $(this).val()).prop('checked', true);
                });
            } else {
                nextDiv.find("input").each(function() {
                    // do something with each input element here
                    //console.log($(this).val());
                    $('#appendPermission #' + $(this).val()).prop('checked', false);
                });
            }
        });
        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            storObject(url, formData, id, "{{ __('Rôle ajouté avec succès') }}",
                "{{ __('Rôle modifié avec succès') }}");
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification de rôle') }}";
            callAjax('GET', url + "/" + id, {}).done(function(response) {
                //$.each(response.role, function(key, val) {
                $('#name').val(response.data.name);
                $.each(response.data.permissions, function(index, value) {
                    $('#appendPermission #' + value).prop('checked', true);
                    //console.log(value);
                });
                $('#title').text(form_title);
                $(".toggle-show").toggleClass('d-none');
            });
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
        }).on('click', '.show', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Voir le rôle') }}";

            callAjax('GET', url + "/" + id, {}).done(function(response) {
                //$.each(response.role, function(key, val) {
                $('#name').val(response.data.name);
                $.each(response.data.permissions, function(index, value) {
                    $('#appendPermission #' + value).prop('checked', true);
                    //console.log(value);
                });
                $('#title').text(form_title);
                form.find('label:first').addClass('d-none');
                form.find('input').attr('disabled', true);
                form.find('.btn-confirm:first').addClass('d-none');
                $(".toggle-show").toggleClass('d-none');
            });
        }).on('click', ".close-btn", (e) => {
            form.find('label:first').removeClass('d-none');
            form.find('input').attr('disabled', false);
            form.find('.btn-confirm:first').removeClass('d-none');
        });
        table = table.DataTable({
            "ajax": ajaxCallDatatables(url),
            columns: [{
                    data: 'name'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                        <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div>
                    <div type="button" id = ${data} class="d-inline pl-3 text-white show"><i class="fas fa-eye text-info    "></i> </div>`;
                    }
                },
            ]
        });

        function permissionsList(index, value) {
            return `<div class="form-check form-switch form-check-inline">
                <input class="form-check-input" type="checkbox" id="${index}" name="permissions[]" role="switch" value="${index}">
                <label class="form-check-label ">${value}</label></div><br>`;
        }
    </script>
@endpush
