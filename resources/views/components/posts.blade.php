<div class="row border-bottom mt-2 gx-0 mx-0">
    <div class="col-4 pb-3 border-end">
        <h6 class="fw-normal fs-5 mb-0">{{ __('Date lancement') }}</h6>
        <span class="fs-3 font-weight-medium text-primary" id="release_date"></span>
    </div>
    <div class="col-4 pb-3 border-end ps-3">
        <h6 class="fw-normal fs-5 mb-0">{{ __('Produit') }}</h6>
        <span class="fs-3 font-weight-medium text-primary" id="product_name"></span>
    </div>
    <div class="col-4 pb-3 border-end ps-3">
        <h6 class="fw-normal fs-5 mb-0">{{ __('Calibre') }}</h6>
        <span class="fs-3 font-weight-medium text-primary " id="caliber_name"></span>
    </div>
</div>

<div class="col-12 mt-2 mx-0">
    <div class="row col-12 text-center">
        <div class="outer mx-auto">
            <canvas id="chartJSContainer" width="auto" height="auto"></canvas>
            <p class="percent" id="percent"></p>
        </div>
    </div>
    <div class="row border-top pb-3  mt-2 gx-0 mx-0">
        <div class="col-6 pt-2 ">
            <h6 class="fw-normal fs-5 mb-0">{{ __('OF') }}</h6>

            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">OK </div>
                    </div>
                    <span class="badge bg-info rounded-pill fs-4" id="of_ok"></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">OK / jour </div>
                    </div>
                    <span class="badge bg-success rounded-pill fs-4" id="of_ok_today"></span>
                </li>
            </ul>
        </div>

        <div class="col-6 pt-2 ">
            <h6 class="fw-normal fs-5 mb-0">{{ __('Opérateur') }}</h6>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">OK / jour </div>
                    </div>
                    <span class="badge bg-success rounded-pill fs-4" id="user_ok_today"></span>
                </li>
                @if (request()->segment(2) !== 'packaging')
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">NOK / jour </div>
                        </div>
                        <span class="badge bg-danger rounded-pill fs-4" id="user_nok_today"></span>
                    </li>
                @else
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Carton reste </div>
                        </div>
                        <span class="badge bg-info rounded-pill fs-4" id="box_rest"></span>
                    </li>
                @endif


            </ul>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
{{-- {{ request()->segment(2) == 'packaging' ? '' : '</div>' }} --}}
@if (request()->segment(2) !== 'packaging')
    </div>
@endif

<div class="col-lg-6 flex-fill {{ request()->segment(2) == 'packaging' ? '' : 'd-none' }} of_info">
    <div class="card shadow border-primary" style="min-height: 90vh">
        <div class="card-body text-white">
            @if (request()->segment(2) == 'serial_numbers')
                <button class="btn btn-info text-white form-inline" id="print_qr" style="display: inline-block;">
                    <i class="mdi mdi-printer mdi-24px"></i>
                    <span style="font-size: 18px">F1</span>
                </button>
                <span class="bg-danger" id="printer_alert"></span>
            @endif
            <div class="table-responsive">
                <table id="main_table" class="table table-sm table-hover  " width="100%">
                    <thead class="bg-light">
                        {{-- <tr> --}}

                        {{-- <th>{{ __('SN') }}</th>
                            <th>{{ __('Créé le') }}</th> --}}
                        {{-- </tr> --}}
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
