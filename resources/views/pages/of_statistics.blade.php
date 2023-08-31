@extends('layouts.app')
@section('breadcrumb')
    <li class="breadcrumb-item " aria-current="page">{{ __('OFs') }}</li>
    <li class="breadcrumb-item active text-capitalize" aria-current="page">{{ __('statistiques') }}</li>
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
                <div class="col-lg-8 ">
                    <div class="card  w-100">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table
                                    class="table mb-0  table-hover align-middle text-nowrap table-light  dt-responsive nowrap "
                                    width="100%" id="ofInfoTable">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th class="border-top-0">{{ __('OF Numéro') }}</th>
                                            <th class="border-top-0">{{ __('produit') }}</th>
                                            <th class="border-top-0">{{ __('calibre') }}</th>
                                            <th class="border-top-0">{{ __('section') }}</th>
                                            <th class="border-top-0">{{ __('qantity lancé') }}</th>
                                            <th class="border-top-0">{{ __('date de lancement') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="col-12 card w-100" style="height: 100px;">
                        <div class="">
                            <div class="card-boy p-3">
                                <h5 class="card-title text-capitalize">{{ __("taux d'avancement") }}</h5>
                                {{-- <h6 class="card-subtitle">Poste 1</h6> --}}
                                <div class="progress mt-2" style="height: 12px;">
                                    <div class="progress-bar bg-info" id="progress_rate" role="progressbar"
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <h6 class="text-muted text-center fw-normal mt-2">
                                    <span></span> <span class="text-capitalize"> {{ __('de production') }} </span>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End roduction chart -->
            <!-- ============================================================== -->

            <!-- ============================================================== -->
            <!-- progress bar rate -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-lg-8 ">
                    <div class="col-12 card w-100" style="min-height:auto;">
                        <div class="card-body">
                            <h6 class="card-subtitle pt-4 text-capitalize text-dark fs-4  ">
                                {{ __('statistique de production par chaque post') }}</h6>
                            <div class="amp-pxl mt-4">
                                <div class="">
                                    <canvas id="chartJSContainer" max-height="350px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- ============================================================== -->
                    <!-- End progress bar rate -->
                    <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- progress in each post -->
                <!-- ============================================================== -->
                <div class="col-lg-4" id="posts_avancement">
                    <div class="col-12 card w-100" style="min-height:auto;">

                        <div class="card-body">
                            <h4 class="card-title text-capitalize">{{ __('avancement par post') }}</h4>
                            <h6 class="card-subtitle mb-5 text-capitalize">
                                {{ __('avancement de production par post') }}</h6>
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
                                <h4 class="card-title pb-2 text-capitalize">
                                    {{ __('resumé sur les Numéros de series') }} </h4>
                            </div>
                            <!-- title -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap table-sm" id="sn_table"
                                    width="100%">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="border-top-0">#</th>
                                            <th class="border-top-0">{{ __('numéro de Serie') }}</th>
                                            <th class="border-top-0">{{ __('poste actuel') }}</th>
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
                        <div class="card-body text-capitalize ">
                            <h4 class="card-title ">{{ __('historique') }}</h4>
                            <h6 class="card-subtitle ">{{ __("historique d'un numéro de serie") }}</h6>
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
                    `<div class="mt-3 pb-3 d-flex align-items-center text-capitalize">
                        <span class="btn  btn-circle d-flex align-items-center text-white" style="background-color:${post.color}">
                            <i class="${post.posts_type.icon}"></i>
                        </span>
                        <div class="ms-3">
                            <h5 class="mb-0 fw-bold" id="post_name">${post.post_name}</h5>
                            <span class="text-muted fs-6 "> {{ __('code de post') }}: <span id="code">${post.code}</span>
                            </span>
                        </div>
                        <div class="ms-auto">
                            <span class="badge bg-light text-dark fs-4" id="movement_percentage">${post.movements_count} {{ __('pcs') }}
                            </span>
                        </div>
                    </div>`;
                i++;
            });

            sn_datatables = table4.DataTable({
                columnDefs: [{
                        targets: [0],
                        visible: false
                    } // Hide the second column (index 1)
                ]
            });
            response.serialNumbers.forEach(product => {
                sn_datatables.rows.add(
                    [
                        [product.id, product.qr,
                            `<span class="badge" style="background-color:${product.color}">${product.post}</span>`
                        ]
                    ]
                ).draw();
            });

            ofInfoTable = $('#ofInfoTable').DataTable({
                searching: false,
                paging: false,
                info: false,
                ordering: false,
            });
            ofInfoTable.rows.add(
                [
                    [
                        `<span class="badge bg-primary">${response.of.of_number}</span>`,
                        response.of.caliber.product.product_name,
                        response.of.caliber.caliber_name,
                        response.of.caliber.product.section.section_name,
                        // response.of.new_quantity,
                        `<span class="badge bg-danger">${response.of.new_quantity}</span>`,
                        response.of.release_date
                    ]
                ]
            ).draw();
            // $("#product").text(response.of.caliber.product.product_name)
            // $("#calibre").text(response.of.caliber.caliber_name)
            // $("#section").text(response.of.caliber.product.section.section_name)
            // $("#new_quantity").text(response.of.new_quantity)
            // $("#of_number").text(response.of.of_number)
            // $("#release_date").text(response.of.release_date)
            // $("#launch_date").text('response.launch_date')
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
                            label: "{{ __('Produisé') }}",
                            // data: [12, 19, 3, 5, 100],
                            data: produced,
                            borderWidth: 1,
                            backgroundColor: "#1a9bfc",
                        },
                        {
                            label: "{{ __('resté') }}",
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
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
                                var value = tooltipItem.yLabel || 0;
                                return datasetLabel + ': ' + value + ' %'; // Add the percentage symbol
                            }
                        }
                    },
                    // tooltips: {
                    //     enabled: false // Disable tooltips for better label visibility
                    // },
                    animation: {
                        onComplete: function() {
                            var chartInstance = this.chart;
                            var ctx = chartInstance.ctx;
                            ctx.textAlign = 'center';
                            ctx.fillStyle = "#6610f2"; // Color of the label text
                            ctx.font = "bold 12px Arial"; // Customize font and size

                            this.data.datasets.forEach(function(dataset, i) {
                                var meta = chartInstance.controller.getDatasetMeta(i);
                                meta.data.forEach(function(bar, index) {
                                    var data = dataset.data[index];
                                    var xPos = bar._model.x;
                                    var yPos = bar._model.y -
                                        20; // Adjust Y position for label above the bar
                                    ctx.fillText(data + ' %', xPos, yPos);
                                });
                            });
                        }
                    }
                },
            });
        })

        function handleClickSN(event) {
            event.preventDefault();
            table4.off('click', 'tr', handleClickSN); // remove the event listener
            let html = "";
            var data = sn_datatables.row(this).data();
            $("#qr_life").html("");
            // send the request to the server
            callAjax("GET", base_url + "/product_life/" + data[0], false).done(function(response) {
                html = "";
                response.forEach(movement => {
                    // Build HTML for post card
                    html +=
                        `<div class="vertical-timeline-item vertical-timeline-element text-capitalize">
                    <div>
                        <span class="vertical-timeline-element-icon bounce-in">
                            <i class="mdi mdi-nut  fs-2 bg-white" style="color:${movement.color}"></i>
                        </span>
                        <div class="vertical-timeline-element-content bounce-in">
                            <h4 class="timeline-title">${movement.post_name}</h4>
                            <p>{{ _('par') }} ${movement.created_by} {{ __('le') }} <a href="javascript:void(0);" data-abc="true">${movement.created_at.split(' ')[0]}</a></p>
                            <span class="vertical-timeline-element-date">${movement.created_at.split(' ')[1]}</span>
                        </div>
                    </div>
                </div>`;
                });
                $("#qr_life").append(html);
                $("#product_history").removeClass("d-none");
                table4.on('click', 'tr', handleClickSN); // remove the event listener
            })
        }
        table4.on('click', 'tr', handleClickSN);
    </script>
@endpush
