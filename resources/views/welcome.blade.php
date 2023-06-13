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
            </div>
            <style>
                /* .carousel-inner {
                                                                                                                                                                                                                                                                                                padding: 1em;
                                                                                                                                                                                                                                                                                            } */

                .card {
                    /* margin: 0 0.5em; */
                    /* margin-block-start: 0.5em; */
                    /* box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
                                                                                                                                                                                                                                                                                                            border: none; */
                }

                .carousel-control-prev,
                .carousel-control-next {
                    background-color: #e1e1e1;
                    width: 6vh;
                    height: 6vh;
                    border-radius: 50%;
                    top: 50%;
                    transform: translateY(-50%);
                }

                @media (min-width: 768px) {
                    .carousel-item {
                        margin-right: 0;
                        flex: 0 0 33.3333333%;
                        display: block;
                    }

                    .carousel-inner {
                        display: flex;
                    }
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
                                feltrage
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">Section</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="section_id" name="section_id"
                                            aria-label="Default select example">

                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">date début et fin</label>
                                    </div>
                                    <div class="col">
                                        <input type="text" value="" class="form-control" id="datetimes"
                                            name="datetimes" />
                                    </div>
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">OF</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="of_id" name="of_id"
                                            aria-label="">
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">{{ __('Calibre') }}</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="caliber_id" name="caliber_id"
                                            aria-label="">
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">GO</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div id="carouselExampleControls" class="carousel mx-0 px-0" data-bs-ride="carousel">
                        <div class="carousel-inner">

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
                </div>
                <div class="col-lg-4">
                    <div class="card my-0 bg-info h-100 ">
                        <div class="card-body">
                            <div class="d-flex flex-row justify-content-between align-items-center">
                                <div class="d-flex flex-colum justify-content-between">
                                    <div
                                        class="
                                   btn btn-xl btn-light-warning
                                   text-warning
                                   btn-circle
                                 ">
                                        <i class="fas fa-chart-line"></i>
                                    </div>

                                </div>
                                <div class=" ms-2 d-block w-100">
                                    <div class="progress mt-3 ">
                                        <div class="progress-bar total_fpy" role="progressbar" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <h3 class="text-start mt-1">FPY de chaine: <span id="total_fpy"></span>%</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- Sales chart -->
            <!-- ============================================================== -->
            <div class="row pt-3">
                <div class="col-lg-8 d-flex align-items-stretch">
                    <div class="card  w-100">
                        <div class="card-body">
                            <div class="d-md-flex align-items-center">
                                <div>
                                    <h4 class="card-title">{{ __('OF Numéro') }}</h4>
                                    <h6 class="card-subtitle">{{ __('Statistique de production par chaque post') }}</h6>
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
                <div class="col-4">
                    <div class="card  w-100">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th class="border-top-0">{{ __('#') }}</th>
                                            <th class="border-top-0">{{ __('OF') }}</th>
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
    <script type="text/javascript">
        var form = $('#main_form');
        $(document).ready(function() {

            callAjax('GET', base_url + '/pluck/sections').done(function(response) {
                appendToSelect(response.data, "#section_id");

            });
            callAjax('GET', base_url + 'p/ofs').done(function(response) {
                appendToSelect(response.data, "#section_id");

            });
            $("#section_id").on("change", function(e) {
                e.preventDefault();
                callAjax('GET', base_url + '/pluck/ofs').done(function(response) {
                    $("#of_id").empty();
                    appendToSelect(response.data, "#of_id");
                });
            });

            form.submit();
        });
        form.on('submit', function(e) {
            e.preventDefault();
            //var splitDates = dateRange();
            let splitDates = $("#datetimes").val().split(' - ');
            // alert(splitDates[0]);
            // return false;
            formData = {
                "section_id": $("#section_id").val(),
                "of_id": $("#of_id").val(),
                "start_date": splitDates[0],
                "end_date": splitDates[1]
            }
            callAjax('GET', base_url + '/dashboard', formData).done(function(response) {
                //$(".MultiCarousel-inner").append()
                var posts_label = [];
                var ok = [],
                    nok = [];

                let items = "";
                let i = "active";
                $("#total_fpy").text(response.data.total_fpy);
                $(".total_fpy").css('width', response.data.total_fpy + "%");

                response.data.fpy.forEach(fpy => {
                    posts_label.push(fpy.post_name);
                    ok.push(fpy.count_ok);
                    nok.push(fpy.count_nok);
                    items += `<div class="carousel-item ${i}">
                        <div class="card my-0 ms-2">
                                    <div class="card-body">
                                        <div class="d-flex flex-row justify-content-between align-items-center">
                                        <div class="d-flex flex-colum justify-content-between">
                                            <div
                                            class="
                                   btn btn-xl btn-light-warning
                                   text-warning
                                   btn-circle
                                 ">
                                             <i class="fas fa-barcode"></i>
                                         </div>

                                        </div>
                                        <div class=" ms-2 d-block w-100">
                                            <div class="progress mt-3">
                                         <div class="progress-bar" role="progressbar" style="width: 100%"
                                             aria-valuenow="${fpy.FPY}" aria-valuemin="0" aria-valuemax="100"></div>
                                     </div>
                                     <h3 class="text-start mt-1">FPY: ${fpy.FPY}%</h3>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="card-footer">
                                        <h3 class="">
                                             <span class="fs-2 ms-1 text-success font-weight-medium"> ${fpy.count_ok} OK</span>
                                             <span class="fs-2 ms-1 text-danger font-weight-medium"> / ${fpy.count_nok} NOK</span>
                                         </h3>
                                    </div>
                                </div>
                            </div>`;
                    i = "";
                });

                posts_chart(posts_label, ok, nok);
                $(".carousel-inner").empty().append(items);
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
                let a = `<div class="item">
                                <div class="card my-0">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div
                                                class="
                                      btn btn-xl btn-light-warning
                                      text-warning
                                      btn-circle
                                    ">
                                                <i class="fas fa-barcode"></i>
                                            </div>
                                            <h3 class="">
                                                <span class="fs-2 ms-1 text-success font-weight-medium"> 44 OK</span>
                                                <span class="fs-2 ms-1 text-danger font-weight-medium"> / 55 NOK</span>
                                            </h3>
                                        </div>

                                        <div class="progress mt-3">
                                            <div class="progress-bar" role="progressbar" style="width: 100%"
                                                aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h3 class="text-start mt-1">FPY: 25%</h3>
                                    </div>
                                </div>
                            </div>`;
                var itemsMainDiv = ('.MultiCarousel');
                var itemsDiv = ('.MultiCarousel-inner');
                var itemWidth = "";
                $('.leftLst, .rightLst').click(function() {
                    var condition = $(this).hasClass("leftLst");
                    if (condition)
                        click(0, this);
                    else
                        click(1, this)
                });
                ResCarouselSize();
                $(window).resize(function() {
                    ResCarouselSize();
                });
                //this function define the size of the items
                function ResCarouselSize() {
                    var incno = 0;
                    var dataItems = ("data-items");
                    var itemClass = ('.item');
                    var id = 0;
                    var btnParentSb = '';
                    var itemsSplit = '';
                    var sampwidth = $(itemsMainDiv).width();
                    var bodyWidth = $('body').width();
                    $(itemsDiv).each(function() {
                        id = id + 1;
                        var itemNumbers = $(this).find(itemClass).length;
                        btnParentSb = $(this).parent().attr(dataItems);
                        itemsSplit = btnParentSb.split(',');
                        $(this).parent().attr("id", "MultiCarousel" + id);
                        if (bodyWidth >= 1200) {
                            // alert(itemsSplit[1]);
                            incno = itemsSplit[1];
                            itemWidth = sampwidth / incno;
                        } else if (bodyWidth >= 992) {
                            incno = itemsSplit[1];
                            itemWidth = sampwidth / incno;
                        } else if (bodyWidth >= 768) {
                            incno = itemsSplit[1];
                            itemWidth = sampwidth / incno;
                        } else {
                            incno = itemsSplit[0];
                            itemWidth = sampwidth / incno;
                        }
                        $(this).css({
                            'transform': 'translateX(0px)',
                            'width': itemWidth * itemNumbers
                        });
                        $(this).find(itemClass).each(function() {
                            $(this).outerWidth(itemWidth);
                        });

                        $(".leftLst").addClass("over");
                        $(".rightLst").removeClass("over");

                    });
                }
                //this function used to move the items
                function ResCarousel(e, el, s) {
                    var leftBtn = ('.leftLst');
                    var rightBtn = ('.rightLst');
                    var translateXval = '';
                    var divStyle = $(el + ' ' + itemsDiv).css('transform');
                    var values = divStyle.match(/-?[\d\.]+/g);
                    var xds = Math.abs(values[4]);
                    if (e == 0) {
                        translateXval = parseInt(xds) - parseInt(itemWidth * s);
                        $(el + ' ' + rightBtn).removeClass("over");

                        if (translateXval <= itemWidth / 2) {
                            translateXval = 0;
                            $(el + ' ' + leftBtn).addClass("over");
                        }
                    } else if (e == 1) {
                        var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
                        translateXval = parseInt(xds) + parseInt(itemWidth * s);
                        $(el + ' ' + leftBtn).removeClass("over");

                        if (translateXval >= itemsCondition - itemWidth / 2) {
                            translateXval = itemsCondition;
                            $(el + ' ' + rightBtn).addClass("over");
                        }
                    }
                    $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
                }
                //It is used to get some elements from btn
                function click(ell, ee) {
                    var Parent = "#" + $(ee).parent().attr("id");
                    var slide = $(Parent).attr("data-slide");
                    ResCarousel(ell, Parent, slide);
                }
                //alert();
                //console.log(response);
            });

            //console.log(posts_label);

        });

        function posts_chart(posts_label, ok, nok) {
            const ctx = document.getElementById('chartJSContainer');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: posts_label,
                    datasets: [{
                            label: "{{ __('OK') }}",
                            data: ok,
                            borderWidth: 1,
                            backgroundColor: "#1a9bfc",
                        },
                        {
                            label: "{{ __('Non Ok') }}",
                            data: nok,
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
        }
    </script>
@endpush
