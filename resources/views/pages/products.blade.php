@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active text-capitalize" aria-current="page">{{ __('produits') }}</li>
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
                        <h4 class="card-title">{{ __('List des produits') }}</h4>
                        <div class="text-end upgrade-btn toggle-show">
                            {{-- <a href="https://www.wrappixel.com/templates/flexy-bootstrap-admin-template/" class="btn btn-primary text-white"
                                target="_blank">Upgrade to Pro</a> --}}
                            @can('product-create')
                                @include('components.add_btn', ['label' => 'Nouveau'])
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead class="bg-light">
                                <tr>
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('code') }}</th>
                                    <th>{{ __('produit') }}</th>
                                    <th>{{ __('section') }}</th>
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
                    <div class="card-body text-capitalize">
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('code') }}:*</label>
                                <input type="text" name="product_code" id="product_code" class="form-control"
                                    placeholder="{{ __('code') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="product_code-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <label>{{ __('produit') }}:*</label>
                                <input type="text" name="product_name" id="product_name" class="form-control"
                                    placeholder="{{ __('produit') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="product_name-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-12">
                                <label>{{ __('section') }}:*</label>
                                <div class="input-group mb-3">
                                    <select id="section_id" class=""
                                        data-placeholder="{{ __('selectionner une section') }}" name="section_id">
                                        <option></option>
                                    </select>
                                    <span class="invalid-feedback" role="alert">
                                        <strong id="section_id-error"></strong>
                                    </span>
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
            form_title = " {{ __('Nouveau Produit') }}",
            url = base_url + '/products';

        formToggle(form_title);

        $(document).ready(function() {
            /*----------------------get sections list ---------------------------*/
            // appendToSelect('GET', base_url + '/pluck/sections', "#section_id");
            callAjax('GET', base_url + '/pluck/sections').done(function(response) {
                appendToSelect(response.data, "#section_id");
            });

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
        });

        var collapsedGroups = {};
        table = table.DataTable({
            "ajax": ajaxCallDatatables(url),
            columns: [{
                    data: 'product_code'
                },
                {
                    data: 'product_name'
                }, {
                    data: 'section.section_name'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `@can('product-edit') <div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div> @endcan
                        @can('product-delete') <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div> @endcan`;
                    }
                },
            ],
            rowGroup: {
                // Uses the 'row group' plugin
                dataSrc: 'section.section_name',
                startRender: function(rows, group) {
                    var collapsed = !!collapsedGroups[group];

                    rows.nodes().each(function(r) {
                        r.style.display = 'none';
                        if (collapsed) {
                            r.style.display = '';
                        }
                    });

                    // Add category name to the <tr>. NOTE: Hardcoded colspan
                    return $('<tr/>')
                        .append('<td colspan="3"> Section: ' + group + ' (' + rows.count() + ')</td>')
                        .attr('data-name', group)
                        .toggleClass('collapsed', collapsed);
                }
            },

            "columnDefs": [{
                "targets": 2,
                "visible": false
            }],

            order: ['2', "asc"],
            paging: false,
        });

        table.on('click', 'tr.dtrg-start', function() {

            var name = $(this).data('name');
            collapsedGroups[name] = !collapsedGroups[name];
            table.draw(false);
        });
    </script>
@endpush
