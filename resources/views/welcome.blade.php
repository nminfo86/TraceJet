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
            <div class="row">
                <div class="col-lg-8 col-md-6 col-12 align-self-center">
                    <h4 class="text-muted mb-0 fw-normal">Welcome Johnathan</h4>
                    <h1 class="mb-0 fw-bold">eCommerce Dashboard</h1>
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
                        Add New
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart">
                                        <line x1="12" y1="20" x2="12" y2="10"></line>
                                        <line x1="18" y1="20" x2="18" y2="4"></line>
                                        <line x1="6" y1="20" x2="6" y2="16"></line>
                                    </svg>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0 d-flex align-items-center">
                                    423,39
                                    <span class="fs-2 ms-1 text-success font-weight-medium">+38%</span>
                                </h3>
                                <h6 class="text-muted mb-0 fw-normal">Sales</h6>
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
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                                        <polyline points="23 4 23 10 17 10"></polyline>
                                        <polyline points="1 20 1 14 7 14"></polyline>
                                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15">
                                        </path>
                                    </svg>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    835
                                    <span class="fs-2 ms-1 text-danger font-weight-medium">-12%</span>
                                </h3>
                                <h6 class="text-muted mb-0 fw-normal">Refunds</h6>
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
                <div class="col-lg-4 d-flex align-items-stretch">
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
                </div>
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
