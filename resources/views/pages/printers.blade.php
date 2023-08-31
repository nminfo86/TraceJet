@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active text-capitalize" aria-current="page">{{ __('imprimantes') }}</li>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row toggle-show">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-capitalize">
                    <div class="d-flex justify-content-between mb-3">
                        <h4 class="card-title">{{ __('liste des postes') }}</h4>
                        <div class="text-end upgrade-btn toggle-show">
                            @include('components.add_btn', ['label' => 'Nouveau'])
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap" width="100%">
                            <thead class="bg-light">
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('Nom') }}</th>
                                    <th>{{ __('IP') }}</th>
                                    <th>{{ __('Port') }}</th>
                                    <th>{{ __('Protocole') }}</th>
                                    <th>{{ __('Label size') }}</th>

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
        <div class="w-70">
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
                                <label>{{ __('Nom d\'imprimanre') }}:*</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="{{ __('Nom d\'imprimante') }}" />
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="name-error"></strong>
                                    </span>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <label for="ip_address">{{ __('IP address') }}</label>
                                <input type="text" id="ip_address" name="ip_address" class="form-control"
                                    placeholder="address IP">
                                <span class="invalid-feedback" role="alert">
                                    <strong id="ip_address-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-3">
                                <label>{{ __('port') }}:*</label>
                                <input type="text" name="port" id="port" class="form-control"
                                    placeholder="{{ __('port') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="port-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-3">
                                <label>{{ __('protocol') }}:*</label>
                                {{-- <select id="protocol" name="protocol" data-placeholder="{{ __('Selectionner coleur') }}">
                                    <option></option>
                                </select> --}}
                                <input type="protocol" name="protocol" id="protocol" class="form-control"
                                    placeholder="{{ __('protocol') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="protocol-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-3">
                                <label>{{ __('Label') }}:*</label>

                                <input type="text" class="form-control" name="label_size" id="label_size" placeholder="">
                                <i class="form-text text-muted">largeur x hauteur ex:(80x20)</i>
                                <span class="invalid-feedback" role="alert">
                                    <strong id="label_size-error"></strong>
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
            form_title = " {{ __('Nouveau Imprimante') }}",
            url = base_url + '/printers';

        formToggle(form_title);

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            storObject(url, formData, id);
        });

        $(document).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification Imprimante') }}";
            editObject(url + '/' + id, form_title);
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            /* ----------------- Fire alert to user about delete warning ---------------- */
            Dialog("{{ __('Confirmer la suppression') }}", "{{ __('Confirmer') }}", "{{ __('Fermer') }}").then((
                result) => {
                /* ---------- if he confirme deleting modal we start delete action ---------- */
                if (result.isConfirmed) {
                    deleteObject(url + '/' + id);
                }
            });
        });

        table = table.DataTable({
            "ajax": ajaxCallDatatables(url),

            columns: [{
                    data: 'name'
                },
                {
                    data: 'ip_address',
                },
                {
                    data: 'port'
                },
                {
                    data: 'protocol'
                }, {
                    data: 'label_size'
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
