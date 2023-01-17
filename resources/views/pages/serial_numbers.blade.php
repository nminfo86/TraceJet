@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Produits') }}</li>
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
    <div class="row">
        <div class="col-6">
            <div class="card border-primary">
                <div class="card-body ">
                    <div class="row">
                        <label for="inputPassword" class="col-2 col-form-label">OF N° :</label>
                        <div class="col-lg-10">
                            <select id="of_id" data-placeholder="{{ __('Selectionner une of') }}" name="of_id"
                                width="100%">
                                <option></option>
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong id="of_id-error"></strong>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 main_table">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">{{ __('Liste des produits') }}</h4>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('QR') }}</th>
                                    <th>{{ __('serial_number') }}</th>
                                    <th>{{ __('OF') }}</th>
                                    <th>{{ __('Etat') }}</th>
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
    {{-- <div class="d-flex justify-content-center toggle-show d-none">
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

                            <div class="col-lg-12">
                                <label>{{ __('Of') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="of_id" class="" data-placeholder="{{ __('Selectionner une of') }}"
                                        name="of_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="of_id-error"></strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('components.footer_form')
                </form>
            </div>
        </div>
    </div> --}}
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
@endsection
@push('custom_js')
    <script type="text/javascript">
        var form = $('#main_form'),
            table = $('#main_table'),
            form_title = " {{ __('Nouveau Produit') }}",
            url = base_url + '/serial_numbers';

        formToggle(form_title);

        $(document).ready(function() {
            /*----------------------get ofs list ---------------------------*/
            callAjax('GET', base_url + '/pluck/ofs').done(function(response) {
                appendToSelect(response.data, "#of_id");
            });
            callAjax('GET', base_url + '/of_status').done(function(response) {
                // appendToSelect(response.data, "#of_id");
                console.log(response);
            });
            //alert(url);
            /*-----------------------intialize select fields ------------------------*/
            //customSelect2("fr");
        });

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            // formData.append("status", $("#status").val());
            storObject(url, formData, id, "{{ __('Produit ajouté avec succès') }}",
                "{{ __('Produit modifié avec succès') }}");
        });

        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification Produit') }}";
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
                    deleteObject(url + '/' + id, "{{ __('Produit supprimé') }}",
                        "{{ __('Suppression impossible') }}");
                }
            });
        }).on("change", "#of_id", function(e) {
            e.preventDefault()
            var of_id = $("#of_id").val();
            table.DataTable({
                // "ajax": url,
                ajax: {
                    type: 'GET',
                    url: url,
                    data: {
                        "of_id": of_id
                    },
                },

                columns: [{
                        data: 'qr'
                    },
                    {
                        data: 'serial_number'
                    }, {
                        data: 'of_code'
                    },
                    {
                        data: 'valid',
                        render: function(data, type, row) {
                            return data == 1 ?
                                `<label class="badge bg-success">${yes}</label>` :
                                `<label class="badge bg-danger">${no}</label>`;
                        }
                    },
                    {
                        data: 'id',
                        // render: function(data, type, row) {
                        //     return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                    // <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div>`;
                        // }
                    },
                ],
                destroy: true,
            });

            $(".main_table").removeClass("d-none");
            // alert("Voulez vous générer le premier QR");
        });
    </script>
@endpush
