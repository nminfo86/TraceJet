@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
@endsection
@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    <div class="row">
        <div class="container-fluid">

            <div class="row">
                <!-- ============================================================== -->
                <!-- Production chart -->
                <!-- ============================================================== -->
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="card  w-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4 class="">{{ __('OF Numéro') }} <span class="badge bg-primary"
                                            id="of_number"></span></h4>
                                </div>
                                <div>
                                    <h4>{{ __('Date de lancement') }} <span class="badge bg-secondary"
                                            id="release_date"></span>
                                    </h4>
                                </div>
                                <div>
                                    <h4 class="">{{ __('Qantity lancé') }} <span class="badge bg-danger"
                                            id="new_quantity"></span></h4>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between pt-2">
                                <div>
                                    <h4 class="">{{ __('Section') }} <span class="badge bg-primary"
                                            id="section"></span></h4>
                                </div>
                                <div>
                                    <h4>{{ __('Produit') }} <span class="badge bg-warning" id="Product"></span>
                                    </h4>
                                </div>
                                <div>
                                    <h4 class="">{{ __('calibre') }} <span class="badge bg-danger"
                                            id="calibre"></span></h4>
                                </div>
                            </div>
                            <h6 class="card-subtitle pt-2">{{ __('Statistique de production par chaque post') }}</h6>
                            <div class="amp-pxl mt-4">
                                <div class="">
                                    <canvas id="chartJSContainer" max-height="350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End roduction chart -->
                <!-- ============================================================== -->
                <div class="col-lg-4 d-flex align-items-stretch" id="posts_avancement">
                    <div class="row">
                        <!-- ============================================================== -->
                        <!-- progress bar rate -->
                        <!-- ============================================================== -->
                        <div class="col-12 card w-100" style="height: 100px;">
                            <div class="">
                                <div class="card-boy p-3">
                                    <h5 class="card-title">taux d'avancement</h5>
                                    {{-- <h6 class="card-subtitle">Poste 1</h6> --}}
                                    <div class="progress mt-2" style="height: 12px;">
                                        <div class="progress-bar bg-info" id="progress_rate" role="progressbar"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h6 class="text-muted text-center fw-normal mt-2">
                                        <span></span> de production
                                    </h6>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================== -->
                        <!-- End progress bar rate -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- progress in each post -->
                        <!-- ============================================================== -->
                        <div class="col-12 card w-100" style="min-height:auto;">
                            <div class="">
                                <div class="card-body">
                                    <h4 class="card-title">avancement par post</h4>
                                    <h6 class="card-subtitle mb-5">avancement de production par post</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Productions chart end -->
            <!-- ============================================================== -->
            <div class="row">
                <!-- ============================================================== -->
                <!-- Table -->
                <!-- ============================================================== -->
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="card w-100">
                        <div class="card-body">
                            <!-- title -->
                            <div class="d-md-flex">
                                <div>
                                    {{-- <h4 class="card-title">{{ __('List de NS') }}</h4> --}}
                                    <h4 class="card-title pb-2">{{ __('Resumé sur les Numéros de series') }} </h4>
                                </div>
                            </div>
                            <!-- title -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap table-sm" id="sn_table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">{{ __('Numéro de Serie') }}</th>
                                            <th class="border-top-0">{{ __('status') }}</th>
                                            {{-- <th class="border-top-0">{{ __('Emplacement') }}</th> --}}
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end Table -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Historique  production of SN -->
                <!-- ============================================================== -->
                <div class="col-lg-4 d-flex align-items-stretch d-none" id="product_history">
                    <div class="card w-100">
                        <div class="card-body">
                            <h4 class="card-title">historique</h4>
                            <h6 class="card-subtitle">historique d'un Numéro de serie</h6>
                            <div class="vertical-timeline vertical-timeline--animate vertical-timeline--one-column"
                                id="qr_life">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!--  End Historique production of SN -->
                <!-- ============================================================== -->
            </div>
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
        /* -------------------------------------------------------------------------- */
        /*                                   js traitement                            */
        /* -------------------------------------------------------------------------- */
        const currentUrl = window.location.pathname; // get the current URL
        const lastSegment = currentUrl.substring(currentUrl.lastIndexOf('/') + 1); // get the last segment of the URL
        var table4 = $("#sn_table");

        // TODO::realtime refresh
        callAjax("GET", base_url + "/of_statistics/" + lastSegment).done(function(response) {

            // Initialize variables
            const posts_list = [],
                produced = [],
                stayed = [];
            let html = "",
                posts = response.of.caliber.product.section.posts;
            // Loop through each post in the response
            // var color_array = ["primary", "warning", "danger", "success", "info"]
            let i = 0;
            posts.forEach(post => {
                // Push post data to respective arrays
                posts_list.push(post.post_name);
                produced.push(post.movement_percentage);
                stayed.push(post.stayed);
                // Build HTML for post card
                html +=
                    `<div class="mt-3 pb-3 d-flex align-items-center">
                        <span class="btn btn-${post.color} btn-circle d-flex align-items-center text-white">
                            <i class="mdi mdi-barcode-scan fs-4"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold" id="post_name">${post.post_name}</h5>
                            <span class="text-muted fs-6">code de post: <span id="code">${post.code}</span>
                            </span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-dark" id="movement_percentage">${post.movements_count} Pcs
                            </span>
                        </div>
                    </div>`;
                i++;
            });

            sn_datatables = table4.DataTable();
            response.serialNumbers.forEach(product => {
                sn_datatables.rows.add(
                    [
                        [product.id, product.qr,
                            `<span class="badge bg-${product.color}">${product.post}</span>`
                        ]
                    ]
                ).draw();
            });

            $("#of_number").text(response.of.of_number)
            $("#new_quantity").text(response.of.new_quantity)
            $("#launch_date").text('response.launch_date')
            $("#section").text(response.of.caliber.product.section.section_name)
            //$("#product").text(response.of.caliber.product.)
            //$("#calibre").text('response.launch_date')
            $("#release_date").text(response.of.release_date)
            $('#progress_rate').css('width', response.of.taux);
            //$('#progress_rate').parent().next("span").text(response.of.taux);
            $('#progress_rate').parent().next().find('span:first').text(response.of.taux)

            // Append the HTML to the DOM
            $("#posts_avancement .card-body").append(html);
            // $("table").append(table).dataTable();

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
                }
            });
        })


        table4.on('click', 'tr', function() {
            let html = "";
            var data = sn_datatables.row(this).data();
            $("#qr_life").html("");
            callAjax("GET", base_url + "/serial_numbers/qr_life/" + data[0], false).done(function(response) {
                html = "";
                response.forEach(movement => {
                    // Build HTML for post card
                    html +=
                        `<div class="vertical-timeline-item vertical-timeline-element">
                        <div>
                            <span class="vertical-timeline-element-icon bounce-in">
                                <i class="mdi mdi-nut text-${movement.color} fs-2 bg-white"></i>
                            </span>
                            <div class="vertical-timeline-element-content bounce-in">
                                <h4 class="timeline-title">${movement.post_name}</h4>
                                <p>opéré par ${movement.created_by} le <a href="javascript:void(0);" data-abc="true">${movement.created_at.split(' ')[0]}</a></p>
                                <span class="vertical-timeline-element-date">${movement.created_at.split(' ')[1]}</span>
                            </div>
                        </div>
                    </div>`;
                });
                $("#qr_life").append(html);
                $("#product_history").removeClass("d-none");
            })
        });
    </script>
@endpush
