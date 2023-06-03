@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Sections') }}</li>
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
                        <h4 class="card-title text-capitalize">{{ __('liste des sections') }}</h4>
                        <div class="text-end upgrade-btn toggle-show">
                            @include('components.add_btn', ['label' => 'Nouveau'])
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="main_table" class="table table-hover dt-responsive nowrap " width="100%">
                            <thead>
                                <tr class="">
                                    {{-- <th>#</th> --}}
                                    <th>{{ __('code') }}</th>
                                    <th>{{ __('nom de section') }}</th>
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
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>{{ __('code de section') }}:*</label>
                                <input type="text" name="section_code" id="section_code" class="form-control"
                                    placeholder="{{ __('EX: 1000') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="section_code-error"></strong>
                                </span>
                            </div>
                            <div class="col-lg-6">
                                <label>{{ __('nom de section') }}:*</label>
                                <input type="text" name="section_name" id="section_name" class="form-control"
                                    placeholder="{{ __('nom de section') }}" />
                                <span class="invalid-feedback" role="alert">
                                    <strong id="section_name-error"></strong>
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
            form_title = " {{ __('Nouvelle section') }}",
            url = base_url + '/sections';

        formToggle(form_title);

        form.on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            storObject(url, formData, id, "{{ __('Section ajoutée avec succès') }}",
                "{{ __('Section modifiée avec succès') }}");
        });

        var caliber_id = 0;
        /* ---------------------------------- Edit ---------------------------------- */
        $(document).on('click', "#add_btn", (e) => {
            // form.find(".row").last().html("klklk");
            $(".status").remove();
            $('#quantity').prop('disabled', false);
        }).on('click', '.edit', function(e) {
            e.preventDefault()
            id = $(this).attr('id');
            form_title = " {{ __('Modification de Section') }}";
            /* ------------------------------ Get Section values ----------------------------- */
            callAjax('GET', url + '/' + id).done(function(response) {
                $(".toggle-show").toggleClass('d-none');
                $('#section_code').val(response.data.section_code);
                $('#section_name').val(response.data.section_name);
                $('#title').text(form_title);
            });
        }).on('click', '.delete', function(e) {
            e.preventDefault();
            id = $(this).attr("id");
            /* ----------------- Fire alert to user about delete warning ---------------- */
            Dialog("{{ __('Confirmer la suppression') }}", "{{ __('Confirmer') }}", "{{ __('Fermer') }}").then((
                result) => {
                /* ---------- if he confirme deleting modal we start delete action ---------- */
                if (result.isConfirmed) {
                    deleteObject(url + '/' + id, "{{ __('Section supprimée') }}",
                        "{{ __('Suppression impossible') }}");
                }
            });
        });


        table = table.DataTable({
            "ajax": ajaxCallDatatables(url),
            columns: [{
                    data: 'section_code'
                },
                {
                    data: 'section_name'
                },
                {
                    data: 'id',
                    render: function(data, type, row) {
                        return `<div type="button" id="${data}" class="d-inline text-white edit"> <i class="fas fa-edit text-warning"></i></div>
                    <div type="button" id = ${data} class="d-inline pl-3 text-white delete"><i class="fas fa-trash text-danger"></i> </div>`;
                    }
                },
            ],

            // order: false
        });
    </script>
@endpush
