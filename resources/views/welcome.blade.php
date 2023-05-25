@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <style>
            .alert-light-info,
            .bg-light-info,
            .btn-light-info {
                background-color: rgba(11, 178, 251, .3) !important;
                border-color: rgba(11, 178, 251, .1) !important
            }

            .alert-light-success,
            .bg-light-success,
            .btn-light-success,
            .email-app .email-table .selected {
                background-color: rgba(57, 203, 127, .3) !important;
                border-color: rgba(57, 203, 127, .1) !important
            }

            .alert-light-warning,
            .bg-light-warning,
            .btn-light-warning {
                background-color: rgba(253, 201, 15, .3) !important;
                border-color: rgba(253, 201, 15, .1) !important
            }

            .alert-light-danger,
            .bg-light-danger,
            .btn-light-danger {
                background-color: rgba(252, 75, 108, .3) !important;
                border-color: rgba(252, 75, 108, .1) !important
            }

            .bg-light-cyan,
            .btn-light-cyan {
                background-color: #405863 !important;
                border-color: #405863 !important
            }

            .alert-light-secondary,
            .bg-light-secondary,
            .btn-light-secondary {
                background-color: rgba(108, 117, 125, .3) !important;
                border-color: rgba(108, 117, 125, .1) !important
            }

            .bg-light-inverse {
                background-color: #0c111b !important
            }

            .alert-light-primary,
            .bg-light-primary,
            .btn-light-primary {
                background-color: rgba(30, 77, 183, .3) !important;
                border-color: rgba(30, 77, 183, .1) !important
            }

            .btn-light-primary:focus,
            .btn-light-primary:hover {
                background-color: #1e4db7 !important;
                border-color: #1e4db7 !important;
                color: #fff !important
            }

            .btn-light-success:focus,
            .btn-light-success:hover {
                background-color: #39cb7f !important;
                border-color: #39cb7f !important;
                color: #fff !important
            }

            .btn-light-warning:focus,
            .btn-light-warning:hover {
                background-color: #fdc90f !important;
                border-color: #fdc90f !important;
                color: #fff !important
            }

            .btn-light-danger:focus,
            .btn-light-danger:hover {
                background-color: #fc4b6c !important;
                border-color: #fc4b6c !important;
                color: #fff !important
            }

            .btn-light-secondary:focus,
            .btn-light-secondary:hover {
                background-color: #6c757d !important;
                border-color: #6c757d !important;
                color: #fff !important
            }

            .btn-light-info:focus,
            .btn-light-info:hover {
                background-color: #0bb2fb !important;
                border-color: #0bb2fb !important;
                color: #fff !important
            }

            .badge-light {
                background-color: #11142d;
                color: #e6e5e8
            }

            .btn-light {
                background-color: #11142d;
                border-color: #11142d;
                color: #e6e5e8
            }

            .badge-light-success {
                background-color: #516d55
            }

            .badge-light-info {
                background-color: #27546f
            }

            .badge-light-danger {
                background-color: #583a41
            }
        </style>
        <div class="container-fluid">
            <div class="row pb-4">
                <div class="col-lg-8 col-md-6 col-12 align-self-center">
                    <h4 class="text-muted mb-0 fw-normal"> {{ __('Bienvenu') }} Johnathan</h4>
                    <h1 class="mb-0 fw-bold">{{ __('Tableau de bord de production') }}</h1>
                </div>
                <div
                    class="
                    col-lg-4 col-md-6
                    d-none d-md-flex
                    align-items-center
                    justify-content-end
                  ">
                    <select class="form-select theme-select border-0" aria-label="Default select example">
                        <option value="1">Today 23 March</option>
                        <option value="2">Today 24 March</option>
                        <option value="3">Today 25 March</option>
                    </select>
                    <a href="javascript:void(0)" class="btn btn-info d-flex align-items-center ms-2">
                        <i class="ri-add-line me-1"></i>
                        all
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card-group">
                        <div class="card">
                            <div class="card-body">
                                <span
                                    class="
                              btn btn-xl btn-light-info
                              text-info
                              btn-circle
                              d-flex
                              align-items-center
                              justify-content-center
                            ">
                                    <i class="fas fa-desktop"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    39,354
                                    <span class="fs-2 ms-1 text-danger font-weight-medium">Postes</span>
                                </h3>
                                {{-- <h6 class="text-muted mb-0 fw-normal">Postes</h6> --}}
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <span
                                    class="
                              btn btn-xl btn-light-warning
                              text-warning
                              btn-circle
                              d-flex
                              align-items-center
                              justify-content-center
                            ">
                                    <i class="fas fa-users"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    4396
                                    <span class="fs-2 ms-1 text-success font-weight-medium">Utilisateurs</span>
                                </h3>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <span
                                    class="
                              btn btn-xl btn-light-danger
                              text-danger
                              btn-circle
                              d-flex
                              align-items-center
                              justify-content-center
                            ">
                                    <i class="fas fa-box-open"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0 d-flex align-items-center">
                                    423,39
                                    <span class="fs-2 ms-1 text-success font-weight-medium">Produits</span>
                                </h3>
                                <h6 class="text-muted mb-0 fw-normal">4146 <span>calibres</span></h6>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <span
                                    class="
                              btn btn-xl btn-light-success
                              text-success
                              btn-circle
                              d-flex
                              align-items-center
                              justify-content-center
                            ">
                                    <i class="mdi mdi-open-in-new"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    835
                                    <span class="fs-2 ms-1 text-danger font-weight-medium">OF</span>
                                </h3>
                                {{-- <h6 class="text-muted mb-0 fw-normal">Refunds</h6> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-info w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title text-white">Filtrage</h4>
                                <div class="ms-auto">
                                    <span
                                        class="
                                  btn btn-lg btn-success btn-circle
                                  d-flex
                                  align-items-center
                                  justify-content-center
                                ">
                                        <i class="mdi mdi-calendar-clock fs-3 rounded text-white"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-around align-items-center">
                                <div>
                                    <h2 class="fs-8 text-white mb-2">du :$93,438.78</h2>
                                    <h2 class="fs-8 text-white mb-0">au :$93,438.78</h2>
                                </div>
                                <div>
                                    <button class="btn btn-danger text-white" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">changer</button>
                                </div> {{-- <span class="text-white op-5">Monthly revenue</span> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="card  w-100">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">{{ __('OF Numéro') }}</h4>
                                    <h6 class="card-subtitle">{{ __('Statistique de production par chaque post') }}</h6>
                                </div>
                                {{-- <div class="ms-auto d-flex no-block align-items-center">
                                    <ul class="list-inline dl d-flex align-items-center m-r-15 m-b-0">
                                        <li class="list-inline-item d-flex align-items-center text-info"><i
                                                class="fa fa-circle font-10 me-1"></i> {{ __('Produise') }}
                                        </li>
                                        <li class="list-inline-item d-flex align-items-center text-primary"><i
                                                class="fa fa-circle font-10 me-1"></i> {{ __('reste') }}
                                        </li>
                                    </ul>
                                </div> --}}
                            </div>
                            <div class="amp-pxl mt-4">
                                <div class="">
                                    <canvas id="chartJSContainer" max-height="350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-boy p-3">
                            <h4 class="card-title">FPY</h4>
                            <h6 class="card-subtitle">Poste 1</h6>
                            <canvas id="FPY1" width="auto" height="auto"></canvas>
                            <p class="percent" id="percent1">
                            </p>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="card  w-100">
                        <div class="card-body">
                            <h4 class="card-title">avancement par post</h4>
                            <h6 class="card-subtitle">avancement de production par post</h6>
                            <div class="mt-5 pb-3 d-flex align-items-center">
                                <span class="btn btn-primary btn-circle d-flex align-items-center">
                                    <i class="mdi mdi-barcode-scan fs-4"></i>
                                </span>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold">Générateur de ticket</h5>
                                    <span class="text-muted fs-6">code de post: 100</span>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted">+68%</span>
                                </div>
                            </div>
                            <div class="py-3 d-flex align-items-center">
                                <span class="btn btn-warning btn-circle d-flex align-items-center">
                                    <i class="mdi mdi-laptop fs-4"></i>
                                </span>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold">Operateur 1</h5>
                                    <span class="text-muted fs-6">code de post: 200</span>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted">+68%</span>
                                </div>
                            </div>
                            <div class="py-3 d-flex align-items-center">
                                <span class="btn btn-success btn-circle d-flex align-items-center">
                                    <i class="mdi mdi-laptop text-white fs-4"></i>
                                </span>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold">Operateur 2</h5>
                                    <span class="text-muted fs-6">code de post: 300</span>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted">+68%</span>
                                </div>
                            </div>
                            <div class="py-3 d-flex align-items-center">
                                <span class="btn btn-info btn-circle d-flex align-items-center">
                                    <i class="mdi mdi-laptop fs-4 text-white"></i>
                                </span>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold">Operateur 3</h5>
                                    <span class="text-muted fs-6">code de post: 400</span>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted">+15%</span>
                                </div>
                            </div>

                            <div class="pt-3 d-flex align-items-center">
                                <span class="btn btn-danger btn-circle d-flex align-items-center">
                                    <i class="mdi mdi-package-variant-closed fs-4 text-white"></i>
                                </span>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold">Emballage</h5>
                                    <span class="text-muted fs-6">code de post: 300</span>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted">+90%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="row">
                {{-- <div class="col-lg-3">
                    <canvas id="FPY1" width="auto" height="auto"></canvas>
                    <p class="percent" id="percent">
                    </p>
                </div> --}}
                <div class="col-3">
                    <div class="card">
                        <div class="card-boy p-3">
                            <h4 class="card-title">FPY</h4>
                            <h6 class="card-subtitle">Poste 1</h6>
                            <canvas id="FPY1" width="auto" height="auto"></canvas>
                            <p class="percent" id="percent1">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-boy p-3">
                            <h4 class="card-title">FPY</h4>
                            <h6 class="card-subtitle">Poste 2</h6>
                            <canvas id="FPY2" width="auto" height="auto"></canvas>
                            <p class="percent" id="percent2">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-boy p-3">
                            <h4 class="card-title">FPY</h4>
                            <h6 class="card-subtitle">Poste 3</h6>
                            <canvas id="FPY3" width="auto" height="auto"></canvas>
                            <p class="percent" id="percent3">
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-boy p-3">
                            <h4 class="card-title">FPY</h4>
                            <h6 class="card-subtitle">Poste 4</h6>
                            <canvas id="FPY4" width="auto" height="auto"></canvas>
                            <p class="percent" id="percent4">
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Table -->
            <!-- ============================================================== -->
            <div class="row">
                <!-- column -->
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <!-- title -->
                            <div class="d-md-flex">
                                <div>
                                    <h4 class="card-title">{{ __('List de NS') }}</h4>
                                    <h5 class="card-subtitle">{{ __('resumé sur les Numéros de series') }} </h5>
                                </div>
                                <div class="ms-auto">
                                    <div class="dl">
                                        <input class="form-control" placeholder={{ __('Chercher NS') }} />
                                    </div>
                                </div>
                            </div>
                            <!-- title -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">{{ __('Numéro de Serie') }}</th>
                                            <th class="border-top-0">{{ __('status') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a
                                                            class="btn btn-circle d-flex btn-info text-white">EA</a>
                                                    </div>
                                                    <div class="">
                                                        <h4 class="m-b-0 font-16">Elite Admin</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <label class="badge bg-danger">ticket_generator</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a
                                                            class="btn btn-circle d-flex btn-orange text-white">MA</a>
                                                    </div>
                                                    <div class="">
                                                        <h4 class="m-b-0 font-16">Monster Admin</h4>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <label class="badge bg-info">Opérateur 1</label>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a
                                                            class="btn btn-circle d-flex btn-success text-white">MP</a>
                                                    </div>
                                                    <div class="">
                                                        <h4 class="m-b-0 font-16">Material Pro Admin</h4>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <label class="badge bg-success">Opérateur 2</label>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="m-r-10"><a
                                                            class="btn btn-circle d-flex btn-purple text-white">AA</a>
                                                    </div>
                                                    <div class="">
                                                        <h4 class="m-b-0 font-16">Ample Admin</h4>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <label class="badge bg-purple">Emballage</label>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <h4 class="card-title">historique</h4>
                            <h6 class="card-subtitle">historique d'un Numéro de serie</h6>
                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column">
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <span class="vertical-timeline-element-icon bounce-in">
                                            <i class="mdi mdi-nut text-info fs-2 bg-white"></i>
                                        </span>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <h4 class="timeline-title">Génération du QR code</h4>
                                            <p>généré par quelqu'un le <a href="javascript:void(0);"
                                                    data-abc="true">12/12/2020</a></p>
                                            <span class="vertical-timeline-element-date">9:30 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <span class="vertical-timeline-element-icon bounce-in">
                                            {{-- <i class=" badge-warning"> </i> --}}
                                            <i class="mdi mdi-nut text-primary fs-2 bg-white"></i>
                                        </span>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <h4 class="timeline-title">Opération une</h4>
                                            <p>opéré par quelqu'un le <a href="javascript:void(0);"
                                                    data-abc="true">12/12/2020</a></p>
                                            <span class="vertical-timeline-element-date">9:30 AM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <span class="vertical-timeline-element-icon bounce-in">
                                            <i class="mdi mdi-nut text-info fs-2 bg-white"></i>
                                        </span>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <p>opération num deux, at <b class="text-danger">3:00 PM</b>
                                            </p>
                                            <p>Yet another one, at <span class="text-success">5:00 PM</span></p>
                                            <span class="vertical-timeline-element-date">12:25 PM</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="vertical-timeline-item vertical-timeline-element">
                                    <div>
                                        <span class="vertical-timeline-element-icon bounce-in">
                                            {{-- <i class=" badge-warning"> </i> --}}
                                            <i class="mdi mdi-nut text-warning fs-2 bg-white"></i>
                                        </span>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <p>Another meeting with UK client today, at <b class="text-danger">3:00 PM</b>
                                            </p>
                                            <p>Yet another one, at <span class="text-success">5:00 PM</span></p>
                                            <span class="vertical-timeline-element-date">12:25 PM</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 472.6 472.6"
                    style="enable-background:new 0 0 472.6 472.6;" xml:space="preserve">
                    <g>
                        <path
                            d="M334.7,94.5c-2.2,0-3.9,1.8-3.9,3.9v39.4c0,2.2,1.8,3.9,3.9,3.9h39.4c2.2,0,3.9-1.8,3.9-3.9V98.4c0-2.2-1.8-3.9-3.9-3.9
		H334.7z M330.8,378v-11.8c0-6.5,5.3-11.8,11.8-11.8c6.5,0,11.8,5.3,11.8,11.8V378H378v-11.8c0-6.5,5.3-11.8,11.8-11.8
		s11.8,5.3,11.8,11.8v23.6c0,6.5-5.3,11.8-11.8,11.8h-94.5c-6.5,0-11.8-5.3-11.8-11.8v-23.6c0-6.5,5.3-11.8,11.8-11.8
		c6.5,0,11.8,5.3,11.8,11.8V378H330.8L330.8,378z M259.9,212.7h11.8c6.5,0,11.8,5.3,11.8,11.8s-5.3,11.8-11.8,11.8h-47.3
		c-6.5,0-11.8-5.3-11.8-11.8s5.3-11.8,11.8-11.8h11.8V189h-35.4c-6.5,0-11.8-5.3-11.8-11.8s5.3-11.8,11.8-11.8h70.9
		c6.5,0,11.8,5.3,11.8,11.8s-5.3,11.8-11.8,11.8h-11.8V212.7z M378,236.3h-11.8c-6.5,0-11.8-5.3-11.8-11.8s5.3-11.8,11.8-11.8H378
		v-11.8c0-6.5,5.3-11.8,11.8-11.8s11.8,5.3,11.8,11.8v47.3c0,6.5-5.3,11.8-11.8,11.8s-11.8-5.3-11.8-11.8V236.3z M259.9,283.5h-11.8
		c-6.5,0-11.8-5.3-11.8-11.8c0-6.5,5.3-11.8,11.8-11.8h23.6c6.5,0,11.8,5.3,11.8,11.8V319c0,6.5-5.3,11.8-11.8,11.8h-70.9
		c-6.5,0-11.8-5.3-11.8-11.8s5.3-11.8,11.8-11.8h59.1V283.5L259.9,283.5z M334.7,70.9h39.4c15.2,0,27.6,12.3,27.6,27.6v39.4
		c0,15.2-12.3,27.6-27.6,27.6h-39.4c-15.2,0-27.6-12.3-27.6-27.6V98.4C307.2,83.2,319.5,70.9,334.7,70.9z M98.4,70.9h39.4
		c15.2,0,27.6,12.3,27.6,27.6v39.4c0,15.2-12.3,27.6-27.6,27.6H98.4c-15.2,0-27.6-12.3-27.6-27.6V98.4
		C70.9,83.2,83.2,70.9,98.4,70.9z M98.4,94.5c-2.2,0-3.9,1.8-3.9,3.9v39.4c0,2.2,1.8,3.9,3.9,3.9h39.4c2.2,0,3.9-1.8,3.9-3.9V98.4
		c0-2.2-1.8-3.9-3.9-3.9H98.4z M98.4,307.2h39.4c15.2,0,27.6,12.3,27.6,27.6v39.4c0,15.2-12.3,27.6-27.6,27.6H98.4
		c-15.2,0-27.6-12.3-27.6-27.6v-39.4C70.9,319.5,83.2,307.2,98.4,307.2z M98.4,330.8c-2.2,0-3.9,1.8-3.9,3.9v39.4
		c0,2.2,1.8,3.9,3.9,3.9h39.4c2.2,0,3.9-1.8,3.9-3.9v-39.4c0-2.2-1.8-3.9-3.9-3.9H98.4z M259.9,94.5h-59.1
		c-6.5,0-11.8-5.3-11.8-11.8c0-6.5,5.3-11.8,11.8-11.8h70.9c6.5,0,11.8,5.3,11.8,11.8V130c0,6.5-5.3,11.8-11.8,11.8
		c-6.5,0-11.8-5.3-11.8-11.8V94.5z M200.8,141.8c-6.5,0-11.8-5.3-11.8-11.8c0-6.5,5.3-11.8,11.8-11.8h23.6c6.5,0,11.8,5.3,11.8,11.8
		c0,6.5-5.3,11.8-11.8,11.8H200.8z M82.7,283.5c-6.5,0-11.8-5.3-11.8-11.8c0-6.5,5.3-11.8,11.8-11.8H130c6.5,0,11.8,5.3,11.8,11.8
		c0,6.5-5.3,11.8-11.8,11.8H82.7z M177.2,283.5c-6.5,0-11.8-5.3-11.8-11.8c0-6.5,5.3-11.8,11.8-11.8h23.6c6.5,0,11.8,5.3,11.8,11.8
		c0,6.5-5.3,11.8-11.8,11.8H177.2z M212.7,378v11.8c0,6.5-5.3,11.8-11.8,11.8s-11.8-5.3-11.8-11.8v-23.6c0-6.5,5.3-11.8,11.8-11.8
		h47.3c6.5,0,11.8,5.3,11.8,11.8c0,6.5-5.3,11.8-11.8,11.8H212.7z M165.4,212.7h11.8c6.5,0,11.8,5.3,11.8,11.8s-5.3,11.8-11.8,11.8
		h-23.6c-6.5,0-11.8-5.3-11.8-11.8v-11.8H130c-6.5,0-11.8-5.3-11.8-11.8S123.4,189,130,189h23.6c6.5,0,11.8,5.3,11.8,11.8V212.7z
		 M70.9,200.8c0-6.5,5.3-11.8,11.8-11.8c6.5,0,11.8,5.3,11.8,11.8v23.6c0,6.5-5.3,11.8-11.8,11.8c-6.5,0-11.8-5.3-11.8-11.8V200.8z
		 M307.2,200.8c0-6.5,5.3-11.8,11.8-11.8s11.8,5.3,11.8,11.8v47.3c0,6.5-5.3,11.8-11.8,11.8s-11.8-5.3-11.8-11.8V200.8z
		 M354.4,307.2v-11.8c0-6.5,5.3-11.8,11.8-11.8h23.6c6.5,0,11.8,5.3,11.8,11.8c0,6.5-5.3,11.8-11.8,11.8H378V319
		c0,6.5-5.3,11.8-11.8,11.8H319c-6.5,0-11.8-5.3-11.8-11.8v-23.6c0-6.5,5.3-11.8,11.8-11.8s11.8,5.3,11.8,11.8v11.8H354.4z
		 M23.6,106.3c0,6.5-5.3,11.8-11.8,11.8S0,112.9,0,106.3V59.1C0,26.4,26.4,0,59.1,0h47.3c6.5,0,11.8,5.3,11.8,11.8
		s-5.3,11.8-11.8,11.8H59.1c-19.6,0-35.4,15.9-35.4,35.4V106.3z M366.2,23.6c-6.5,0-11.8-5.3-11.8-11.8S359.7,0,366.2,0h47.3
		c32.6,0,59.1,26.4,59.1,59.1v47.3c0,6.5-5.3,11.8-11.8,11.8s-11.8-5.3-11.8-11.8V59.1c0-19.6-15.9-35.4-35.4-35.4H366.2z
		 M106.3,448.9c6.5,0,11.8,5.3,11.8,11.8s-5.3,11.8-11.8,11.8H59.1C26.4,472.6,0,446.1,0,413.5v-47.3c0-6.5,5.3-11.8,11.8-11.8
		s11.8,5.3,11.8,11.8v47.3c0,19.6,15.9,35.4,35.4,35.4H106.3z M448.9,366.2c0-6.5,5.3-11.8,11.8-11.8s11.8,5.3,11.8,11.8v47.3
		c0,32.6-26.4,59.1-59.1,59.1h-47.3c-6.5,0-11.8-5.3-11.8-11.8s5.3-11.8,11.8-11.8h47.3c19.6,0,35.4-15.9,35.4-35.4V366.2z" />
                    </g>
                </svg>
            </div>


            <!-- ============================================================== -->
            <!-- Table -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom_js')
    <script type="text/javascript">
        // var options1 = {
        //     type: 'bar',
        //     data: {
        //         labels: ["{{ __('  réalisé') }}", "{{ __('  à réaliser') }}"],
        //         datasets: [{
        //             label: '# of Votes',
        //             data: [10, 2],
        //             backgroundColor: [
        //                 'rgba(46, 204, 113, 1)'
        //             ],
        //             borderColor: [
        //                 'rgba(255, 255, 255 ,1)'
        //             ],
        //             borderWidth: 5
        //         }]
        //     },
        //     options: {
        //         rotation: 1 * Math.PI,
        //         circumference: 1 * Math.PI,
        //         legend: {
        //             display: false
        //         },
        //         tooltip: {
        //             enabled: false
        //         },
        //         cutoutPercentage: 85
        //     }
        // }
        // var ctx1 = document.getElementById('chartJSContainer').getContext('2d');
        // var chart1 = new Chart(ctx1, options1);
        const ctx = document.getElementById('chartJSContainer');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Générateur', 'Opé_1', 'Opé_2', 'Opé_3', 'Emballage'],
                datasets: [{
                        label: "{{ __('Produise') }}",
                        data: [12, 19, 3, 5, 3],
                        borderWidth: 1,
                        backgroundColor: "#1a9bfc",
                    },
                    {
                        label: "{{ __('reste') }}",
                        data: [12, 19, 3, 5, 5],
                        borderWidth: 1,
                        backgroundColor: "#1e4db7",
                    }
                ],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                //legend: false,
            }
        });


        $("#percent1").text(92 + ' %');
        $("#percent2").text(90 + ' %');
        $("#percent3").text(98 + ' %');
        $("#percent4").text(80 + ' %');
        var options1 = {
            type: 'doughnut',
            data: {
                labels: ["{{ __('  réalisé') }}", "{{ __('  à réaliser') }}"],
                datasets: [{
                    label: '# of Votes',
                    data: [92, 8],
                    backgroundColor: [
                        'rgba(46, 204, 113, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 255, 255 ,1)'
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                rotation: 1 * Math.PI,
                circumference: 1 * Math.PI,
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                },
                cutoutPercentage: 85
            }
        }
        var ctx1 = document.getElementById('FPY1').getContext('2d');
        var ctx2 = document.getElementById('FPY2').getContext('2d');
        var ctx3 = document.getElementById('FPY3').getContext('2d');
        var ctx4 = document.getElementById('FPY4').getContext('2d');
        var chart1 = new Chart(ctx1, options1);
        var chart2 = new Chart(ctx2, options1);
        var chart3 = new Chart(ctx3, options1);
        var chart4 = new Chart(ctx4, options1);
    </script>
@endpush
