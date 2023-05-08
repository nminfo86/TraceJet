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
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="card  w-100">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">{{ __('OF Numéro') }} <span class="badge bg-primary"
                                            id="of_number"></span></h4>
                                    <h6 class="card-subtitle">{{ __('Statistique de production par chaque post') }}</h6>
                                </div>
                                <div class="ms-auto d-flex no-block align-items-center">
                                    <h4 class="card-title">{{ __('Qantity') }} <span class="badge bg-primary"
                                            id="new_quantity"></span></h4>

                                </div>
                            </div>
                            <div class="amp-pxl mt-4">
                                <div class="">
                                    <canvas id="chartJSContainer" max-height="350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-items-stretch" id="posts_avancement">
                    <div class="card  w-100">
                        <div class="card-body">
                            <h4 class="card-title">avancement par post</h4>
                            <h6 class="card-subtitle mb-5">avancement de production par post</h6>
                            {{-- <div class="mt-5 pb-3 d-flex align-items-center">
                                <span class="btn btn-primary btn-circle d-flex align-items-center">
                                    <i class="mdi mdi-barcode-scan fs-4"></i>
                                </span>
                                <div class="ms-3">
                                    <h5 class="mb-0 fw-bold" id="post_name">Générateur de ticket</h5>
                                    <span class="text-muted fs-6">code de post: <span id="code"></span></span>
                                </div>
                                <div class="ms-auto">
                                    <span class="badge bg-light text-muted" id="movement_percentage">+68%</span>
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
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="row">
                {{-- <div class="col-lg-3">
                    <canvas id="FPY1" width="auto" height="auto"></canvas>
                    <p class="percent" id="percent">
                    </p>
                </div>
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
            </div> --}}
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
                                            {{-- <th class="border-top-0">{{ __('Emplacement') }}</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- <tr>
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

                                        </tr> --}}
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
                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column"
                                id="qr_life">
                                {{-- <div class="vertical-timeline-item vertical-timeline-element">
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

                                            <i class="mdi mdi-nut text-warning fs-2 bg-white"></i>
                                        </span>
                                        <div class="vertical-timeline-element-content bounce-in">
                                            <p>Another meeting with UK client today, at <b class="text-danger">3:00 PM</b>
                                            </p>
                                            <p>Yet another one, at <span class="text-success">5:00 PM</span></p>
                                            <span class="vertical-timeline-element-date">12:25 PM</span>
                                        </div>
                                    </div>
                                </div> --}}

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



        // $("#percent1").text(92 + ' %');
        // $("#percent2").text(90 + ' %');
        // $("#percent3").text(98 + ' %');
        // $("#percent4").text(80 + ' %');
        // var options1 = {
        //     type: 'doughnut',
        //     data: {
        //         labels: ["{{ __('  réalisé') }}", "{{ __('  à réaliser') }}"],
        //         datasets: [{
        //             label: '# of Votes',
        //             data: [92, 8],
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
        // var ctx1 = document.getElementById('FPY1').getContext('2d');
        // var ctx2 = document.getElementById('FPY2').getContext('2d');
        // var ctx3 = document.getElementById('FPY3').getContext('2d');
        // var ctx4 = document.getElementById('FPY4').getContext('2d');
        // var chart1 = new Chart(ctx1, options1);
        // var chart2 = new Chart(ctx2, options1);
        // var chart3 = new Chart(ctx3, options1);
        // var chart4 = new Chart(ctx4, options1);


        /* -------------------------------------------------------------------------- */
        /*                                   Boualem                                  */
        /* -------------------------------------------------------------------------- */
        callAjax("GET", "{{ url('dash') }}", data = {
            of_id: 1
        }).done(function(response) {
            // console.log(response);
            // Initialize variables
            const posts_list = [];
            const produced = [];
            const stayed = [];
            let html = "";
            let table = "";
            console.log(response.of.serial_numbers);
            // Loop through each post in the response
            response.posts.forEach(post => {
                // Push post data to respective arrays
                posts_list.push(post.post_name);
                produced.push(post.movement_percentage);
                stayed.push(post.stayed);

                // Build HTML for post card
                html +=
                    `<div class="mt-3 pb-3 d-flex align-items-center">
                        <span class="btn btn-primary btn-circle d-flex align-items-center">
                            <i class="mdi mdi-barcode-scan fs-4"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold" id="post_name">${post.post_name}</h5>
                            <span class="text-muted fs-6">code de post: <span id="code">${post.code}</span>
                            </span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-success text-white" id="movement_percentage">${post.movements_count} Pcs
                            </span>
                        </div>
                    </div>`;
            });
            response.of.serial_numbers.forEach(product => {
                table +=
                    `<tr>
                        <td>
                            <label class="m-b-0 font-16">${product.qr}</label>
                        </td>
                        <td>
                            <label class="badge bg-success ">${product.valid}</label>
                        </td>
                    </tr>`;
            });
            $("#of_number").text(response.of.of_number)
            $("#new_quantity").text(response.of.new_quantity)

            // Append the HTML to the DOM
            $("#posts_avancement .card-body").append(html);
            $("table tbody").append(table);

            /* -------------------------------------------------------------------------- */
            /*                                    Char                                    */
            /* -------------------------------------------------------------------------- */
            const ctx = document.getElementById('chartJSContainer');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    // labels: ['Générateur', 'Opé_1', 'Opé_2', 'Opé_3', 'Emballage'],
                    labels: posts_list,
                    datasets: [{
                            label: "{{ __('Produise') }}",
                            // data: [12, 19, 3, 5, 100],
                            data: produced,
                            borderWidth: 1,
                            backgroundColor: "#1a9bfc",
                        },
                        {
                            label: "{{ __('reste') }}",
                            // data: [12, 19, 3, 5, 5],
                            data: stayed,
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


        })

        callAjax("GET", "{{ url('sn_dash') }}", data = {
            sn_id: 1
        }).done(function(response) {
            html = "";
            response.forEach(movement => {
                // Build HTML for post card
                html +=
                    `<div class="vertical-timeline-item vertical-timeline-element">
                        <div>
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="mdi mdi-nut text-primary fs-2 bg-white"></i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title">${movement.post_name}</h4>
                                <p>opéré par quelqu'un le <a href="javascript:void(0);" data-abc="true">${movement.created_at.split(' ')[0]}</a></p>
                                <span class="vertical-timeline-element-date">${movement.created_at.split(' ')[1]}</span>
                            </div>
                        </div>
                    </div>`;
            });
            $("#qr_life").append(html);
        })
    </script>
@endpush
