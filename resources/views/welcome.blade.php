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
            <div class="row pb-2">
                <div class="col-lg-8 col-md-6 col-12 align-self-center">
                    {{-- <h4 class="text-muted mb-0 fw-normal"> {{ __('Bienvenu') }} </h4> --}}
                    <h3 class="mb-0 fw-bold">{{ __('Tableau de bord de production') }}</h3>
                </div>
            </div>
            {{-- custom style carousel in dashboard --}}
            <style>
                .carousel-inner {
                    padding: 1em;
                }

                .card {
                    margin: 0 0.5em;
                    box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
                    border: none;
                }

                .carousel-control-prev,
                .carousel-control-next {
                    /* background-color: transparent; */
                    width: 40px;
                    height: 40px;
                    border: none;
                    border-radius: 50%;
                    top: 50%;
                    transform: translateY(-50%);
                }

                @media (min-width: 768px) {
                    .carousel-item {
                        margin-right: 0;
                        flex: 0 0 33.333333%;
                        display: block;
                    }

                    .carousel-inner {
                        display: flex;
                    }
                }

                .card .img-wrapper {
                    max-width: 100%;
                    height: 13em;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }

                .card img {
                    max-height: 100%;
                }

                @media (max-width: 767px) {
                    .card .img-wrapper {
                        height: 17em;
                    }
                }
            </style>
            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <form id="main_form">
                            <div class="card-header bg-info text-white">
                                {{ __('filtrage') }}
                            </div>
                            <div class="card-body bg-light">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">{{ __('Section') }}</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="section_id" name="section_id"
                                            aria-label="Default select example">
                                            <option selected disabled>{{ __('selectionner une section') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">{{ __('date début et fin') }}</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" value="" class="form-control" id="datetimes"
                                            name="datetimes" />
                                    </div>

                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">{{ __('Calibre') }}</label>
                                    </div>
                                    <div class="col d-flex">
                                        <div class="w-75">
                                            <select class="form-select theme-select border-0" id="caliber_id"
                                                name="caliber_id" aria-label="">
                                                <option value="0" selected disabled>{{ __('choisir un calibre') }}
                                                </option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-secondary ms-1"
                                                id="deselect_caliber_id">tous</button>
                                        </div>
                                        {{-- <div class="input-group mb-3">
                                            <select class="form-select" id="inputGroupSelect02">
                                                <option selected>Choose...</option>
                                                <option value="1">One</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <label class="input-group-text" for="inputGroupSelect02">Options</label>
                                        </div> --}}

                                    </div>
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">{{ __('OF') }}</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="of_id" name="of_id"
                                            aria-label="">
                                            <option selected disabled>{{ __('choisir un OF') }}</option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">{{ __('GO') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="form-row d-none after-filter">
                    <h3 class="pt-4 ps-4">First past yield pour chaque poste </h3>
                </div>
                <div id="carouselExampleControls" class="carousel col-lg-9 d-none after-filter" data-bs-ride="carousel">

                    <div class="carousel-inner">
                        {{-- <div class="carousel-item active">
                            <div class="card">
                                <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                                <div class="card-body">
                                    <h5 class="card-title">Card title 1</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the
                                        bulk of the
                                        card's content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="card">
                                <div class="img-wrapper"><img src="..." class="d-block w-100" alt="..."> </div>
                                <div class="card-body">
                                    <h5 class="card-title">Card title 2</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the
                                        bulk of the
                                        card's content.</p>
                                    <a href="#" class="btn btn-primary">Go somewhere</a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="col-lg-3">
                    <div class="row d-flex align-items-center " style="height: 180px">
                        <div class="col-xs-6 fpyTotal-inner">

                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <h1 class="text-center before-filter">{{ __('Filtrer pour voir les résulats') }}</h1>
            <div class="row pt-3 d-none after-filter">
                <div class="col-lg-6 ">
                    <div class="card  w-100">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">{{ __('OF Numéro') }}</h4>
                                    <h6 class="card-subtitle">{{ __('Statistiques de production par chaque post') }}</h6>
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
                <div class="col-6 ">
                    <div class="card  w-100 ">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">{{ __('Liste des Ofs') }}</h4>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap" id="main_table"
                                    width="100%">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th class="border-top-0">{{ __('OF Numéro') }}</th>
                                            <th class="border-top-0">{{ __('calibre') }}</th>
                                            <th class="border-top-0">{{ __('statut') }}</th>
                                            <th class="border-top-0">{{ __('action') }}</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="{{ asset('/dist/js/chart/chart.min.js') }}"></script>
    <script type="text/javascript">
        var form = $('#main_form');
        var table = $('#main_table');
        url = base_url + "/ofsBySection";
        $(document).ready(function() {

            callAjax('GET', base_url + '/pluck/sections', {
                has: "posts"
            }).done(function(response) {
                appendToSelect(response.data, "#section_id");
            });
            $("#section_id").on("change", function(e) {
                e.preventDefault();
                let id = $(this).val();
                $("#of_id").empty().append("<option selected disabled>{{ __('choisir un OF') }}</option>");
                callAjax('GET', base_url + '/pluck/calibers', {
                    "section_id": id,
                    'has': "product"
                }).done(function(response) {
                    $("#caliber_id").empty().append(
                        "<option selected disabled>{{ __('choisir un calibre') }}</option>");
                    appendToSelect(response.data, "#caliber_id");
                });
            });

            $("#caliber_id").on("change", function(e) {
                e.preventDefault();
                let id = $(this).val();
                callAjax('GET', base_url + '/pluck/ofs', {
                    "caliber_id": id,
                    "has": "caliber"
                }).done(function(response) {
                    $("#of_id").empty().append(
                        "<option selected disabled>{{ __('choisir un OF') }}</option>");
                    appendToSelect(response.data, "#of_id");
                });
            });

            $('#deselect_caliber_id').click(function(e) {
                e.preventDefault();
                //let first_option = $('#caliber_id option:first');
                $("#caliber_id option:nth-child(1)").prop("disabled", false);

                //first_option.prop('disabled', false);
                $("#caliber_id").val($("#caliber_id option:nth-child(1)").val()).trigger("change");
                $("#caliber_id option:nth-child(1)").prop('disabled', true);
            })
        });
        form.on('submit', function(e) {
            e.preventDefault();

            let splitDates = $("#datetimes").val().split(' - ');

            formData = {
                "section_id": $("#section_id").val(),
                "of_id": $("#of_id").val(),
                "caliber_id": $("#caliber_id").val(),
                "start_date": splitDates[0],
                "end_date": splitDates[1]
            }
            callAjax('GET', base_url + '/dashboard', formData).done(function(response) {
                //$(".MultiCarousel-inner").append()
                $(".before-filter").addClass('d-none');
                $(".after-filter").removeClass('d-none');
                let items_t = "";
                var i = "active";
                var post_names = [];
                var dataset_ok = [];
                var dataset_nok = [];
                response.data.fpy.forEach(element => {
                    post_names.push(element.post_name);
                    dataset_ok.push(element.count_ok);
                    dataset_nok.push(element.count_nok);
                    items_t += `<div class="carousel-item ${i}">
                                    <div class="col">
                                        <div class="card me-lg-3">
                                            <div class="card-img ">
                                                <div class="card-body">
                                                    <h5 class="card-title  ">
                                                    <i class="${element.icon} fs-3 me-2" style="color:${element.color}"></i> ${element.post_name}</h5>
                                                    <div class="progress" style="height: 20px;">
                                                        <div class="progress-bar bg-info" role="progressbar"
                                                            style="width:${element.FPY}%;" aria-valuenow="${element.FPY}" aria-valuemin="0" aria-valuemax="100"> FPY ${element.FPY}%
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-white fs-3">
                                                    <div class="row text-center">
                                                        <div class="col border-end text-success">
                                                            <div class="">OK</div> <span class="badge bg-success fs-4">${element.count_ok}</span>
                                                        </div>
                                                        <div class="col text-danger">
                                                            <div class="">NOK</div> <span class="badge bg-danger fs-4 ">${element.count_nok}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                    i = "";
                });
                $(".carousel-inner").empty().append(items_t);
                $(".fpyTotal-inner").empty().append(`
                    <h3> FPY total </h3>
                    <div class="progress-middle">
                        <div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" style="width: ${response.data.total_fpy}%" aria-valuenow="${response.data.total_fpy}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <h3 class="text-center"> ${response.data.total_fpy} % </h3>
             `);
                var multipleCardCarousel = document.querySelector(
                    "#carouselExampleControls"
                );
                if (window.matchMedia("(min-width: 768px)").matches) {
                    var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                        interval: false,
                    });
                    var carouselWidth = $(".carousel-inner")[0].scrollWidth;
                    var cardWidth = $(".carousel-item").width();
                    var scrollPosition = 0;
                    $("#carouselExampleControls .carousel-control-next").on("click", function() {
                        if (scrollPosition < carouselWidth - cardWidth * 4) {
                            scrollPosition += cardWidth;
                            $("#carouselExampleControls .carousel-inner").animate({
                                    scrollLeft: scrollPosition
                                },
                                600
                            );
                        }
                    });
                    $("#carouselExampleControls .carousel-control-prev").on("click", function() {
                        if (scrollPosition > 0) {
                            scrollPosition -= cardWidth;
                            $("#carouselExampleControls .carousel-inner").animate({
                                    scrollLeft: scrollPosition
                                },
                                600
                            );
                        }
                    });
                } else {
                    $(multipleCardCarousel).addClass("slide");
                }

                /*--------------------------- barchar -----------------------------------------*/
                const ctx = document.getElementById('chartJSContainer');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: post_names,
                        datasets: [{
                                label: "{{ __('OK') }}",
                                data: dataset_ok,
                                borderWidth: 1,
                                backgroundColor: "#1a9bfc",
                            },
                            {
                                label: "{{ __('NOK') }}",
                                data: dataset_nok,
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
                                    var datasetLabel = data.datasets[tooltipItem.datasetIndex]
                                        .label || '';
                                    var value = tooltipItem.yLabel || 0;
                                    return datasetLabel + ': ' +
                                        value; // Add the percentage symbol
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
                                    var meta = chartInstance.controller.getDatasetMeta(
                                        i);
                                    meta.data.forEach(function(bar, index) {
                                        var data = dataset.data[index];
                                        var xPos = bar._model.x;
                                        var yPos = bar._model.y -
                                            15; // Adjust Y position for label above the bar
                                        ctx.fillText(data, xPos, yPos);
                                    });
                                });
                            }
                        }
                        //legend: false,
                    }
                });
                $("#percent1").text(92 + ' %');
                $("#percent2").text(90 + ' %');
                $("#percent3").text(98 + ' %');
                $(
                    "#percent4").text(80 + ' %');
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

                /*---------------------------- datatables ----------------------------*/
                table.DataTable({
                    // "ajax": ajaxCallDatatables(url + '/' + $('#section_id').val()),
                    "data": response.data.ofs,
                    columns: [{
                            data: 'of_number'
                        },
                        {
                            data: 'caliber.caliber_name'
                        }, {
                            data: 'status'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                return `  <a type="button" href="/of_statistics/${data}" class="d-inline pl-3 text-white historic"><i class="fa fa-eye text-info"></i> </a>`;
                            }
                        },
                    ],
                    "destroy": true
                });
            });
        });
    </script>
@endpush
