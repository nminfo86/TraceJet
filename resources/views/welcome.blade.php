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
                @media (max-width: 767px) {
                    .carousel-inner .carousel-item>div {
                        display: none;
                    }

                    .carousel-inner .carousel-item>div:first-child {
                        display: block;
                    }
                }

                .carousel-inner .carousel-item.active,
                .carousel-inner .carousel-item-next,
                .carousel-inner .carousel-item-prev {
                    display: flex;
                }

                /* medium and up screens */
                @media (min-width: 768px) {

                    .carousel-inner .carousel-item-end.active,
                    .carousel-inner .carousel-item-next {
                        transform: translateX(25%);
                    }

                    .carousel-inner .carousel-item-start.active,
                    .carousel-inner .carousel-item-prev {
                        transform: translateX(-25%);
                    }
                }

                .carousel-inner .carousel-item-end,
                .carousel-inner .carousel-item-start {
                    transform: translateX(0);
                }
            </style>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <form id="main_form">
                            <div class="card-header bg-info text-white">
                                {{ __('feltrage') }}
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">Section</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="section_id" name="section_id"
                                            aria-label="Default select example">
                                            <option selected disabled>{{ __('selectionner une section') }}</option>
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
                                        <label for="inputField" class="col-form-label">{{ __('Calibre') }}</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="caliber_id" name="caliber_id"
                                            aria-label="">
                                            <option selected disabled>{{ __('choisir un calibre') }}</option>
                                        </select>

                                    </div>
                                    <div class="col-auto">
                                        <label for="inputField" class="col-form-label">OF</label>
                                    </div>
                                    <div class="col">
                                        <select class="form-select theme-select border-0" id="of_id" name="of_id"
                                            aria-label="">
                                            <option selected disabled>{{ __('choisir un OF') }}</option>
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
                    {{-- <div id="carouselExampleControls" class="carousel mx-0 px-0" data-bs-ride="carousel">
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
                    </div> --}}
                    <div class="container text-center my-3">
                        <div id="recipeCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner" role="listbox">
                                {{-- carousel goes her --}}
                            </div>
                            <a class="carousel-control-prev bg-transparent w-aut" href="#recipeCarousel" role="button"
                                data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </a>
                            <a class="carousel-control-next bg-transparent w-aut" href="#recipeCarousel" role="button"
                                data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    {{-- <div class="carousel-item">
                        <div class="card my-0">
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div class="d-flex flex-colum justify-content-between">
                                        <div class="btn btn-xl btn-light-warning text-warning btn-circle">
                                            <i class="fas fa-barcode"></i>
                                        </div>

                                    </div>
                                    <div class=" ms-2 d-block w-100">
                                        <div class="progress mt-3">
                                            <div class="progress-bar" role="progressbar" style="width: 100%"
                                                aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <h3 class="text-start mt-1">FPY: %</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <h3 class="">
                                    <span class="fs-2 ms-1 text-success font-weight-medium"> </span>
                                    <span class="fs-2 ms-1 text-danger font-weight-medium"> </span>
                                </h3>
                            </div>
                        </div>
                    </div> --}}

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
                    <div class="card  w-100 mt-5">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover align-middle text-nowrap" id="main_table">
                                    <thead>
                                        <tr class="text-capitalize">
                                            <th class="border-top-0">{{ __('Number') }}</th>
                                            <th class="border-top-0">{{ __('Name') }}</th>
                                            <th class="border-top-0">{{ __('Status') }}</th>
                                            <th class="border-top-0">{{ __('Action') }}</th>
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
        var table = $('#main_table');
        url = 'api/v1/ofsBySection';
        $(document).ready(function() {

            callAjax('GET', base_url + '/pluck/sections').done(function(response) {
                appendToSelect(response.data, "#section_id");

            });

            $("#section_id").on("change", function(e) {
                e.preventDefault();
                let id = $(this).val();
                table.DataTable({
                    "ajax": ajaxCallDatatables(url + '/' + id),
                    columns: [{
                            data: 'of_number'
                        },
                        {
                            data: 'of_code'
                        }, {
                            data: 'status'
                        },
                        {
                            data: 'id',
                            render: function(data, type, row) {
                                return `  <a type="button" href="http://127.0.0.1:8000/of_statistics/${data}" class="d-inline pl-3 text-white historic"><i class="fa fa-eye text-info"></i> </a>`;
                            }
                        },
                    ],
                    "destroy": true
                });

                // callAjax('GET', base_url + '/pluck/ofs', {
                //     "section_id": id
                // }).done(function(response) {
                //     $("#of_id").empty();
                //     appendToSelect(response.data, "#of_id");
                // });
                $("#of_id").empty().append("<option selected disabled>{{ __('choisir un OF') }}</option>");
                callAjax('GET', base_url + '/pluck/calibers', {
                    "section_id": id,
                    'has': "ofs"
                }).done(function(response) {
                    $("#caliber_id").empty().append(
                        "<option selected disabled>{{ __('choisir un calibre') }}</option>");
                    appendToSelect(response.data, "#caliber_id");
                });


                // callAjax('GET', base_url + '/pluck/ofs', {
                //     "section_id": id,
                //     'has': "ofs"
                // }).done(function(response) {
                //     $("#caliber_id").empty();
                //     appendToSelect(response.data, "#caliber_id");
                // });


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
            // $("#caliber_id").change();
            // $("#section_id").change();
            //form.submit();


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
                "caliber_id": $("#caliber_id").val(),
                "start_date": splitDates[0],
                "end_date": splitDates[1]
            }
            callAjax('GET', base_url + '/dashboard', formData).done(function(response) {
                //$(".MultiCarousel-inner").append()
                let items_t = "";
                var i = "active";
                response.data.fpy.forEach(element => {
                    items_t += `<div class="carousel-item ${i}">
                                    <div class="col-md-3">
                                        <div class="card mx-3">
                                            <div class="card-img ">
                                                <div class="card-body">
                                                    <h5 class="card-title">${element.post_name}</h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">Subtitle</h6>
                                                    <p class="card-text">Card content goes here.</p>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="row">
                                                    <div class="col">
                                                        Footer section 1
                                                    </div>
                                                    <div class="col">
                                                        Footer section 3
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
                $(".carousel-inner").append(items_t);
                let items = document.querySelectorAll('.carousel .carousel-item')

                items.forEach((el) => {
                    const minPerSlide = 4
                    let next = el.nextElementSibling
                    for (var i = 1; i < minPerSlide; i++) {
                        if (!next) {
                            // wrap carousel by using first child
                            next = items[0]
                        }
                        let cloneChild = next.cloneNode(true)
                        el.appendChild(cloneChild.children[0])
                        next = next.nextElementSibling
                    }
                })
                // let tt = `<div class="d-flex justify-content-between align-items-center">
            //                             <div
            //                                 class="
            //                       btn btn-xl btn-light-warning
            //                       text-warning
            //                       btn-circle
            //                     ">
            //                                 <i class="fas fa-barcode"></i>
            //                             </div>
            //                             <h3 class="">
            //                                 <span class="fs-2 ms-1 text-success font-weight-medium"> ${fpy.count_ok} OK</span>
            //                                 <span class="fs-2 ms-1 text-danger font-weight-medium"> / ${fpy.count_nok} NOK</span>
            //                             </h3>
            //                         </div>

            //                         <div class="progress mt-3">
            //                             <div class="progress-bar" role="progressbar" style="width: 100%"
            //                                 aria-valuenow="${fpy.FPY}" aria-valuemin="0" aria-valuemax="100"></div>
            //                         </div>
            //                         <h3 class="text-start mt-1">FPY: ${fpy.FPY}%</h3>`;

                // $(".carousel-inner").empty().append(items);
                // var multipleCardCarousel = document.querySelector(
                //     "#carouselExampleControls"
                // );
                // if (window.matchMedia("(min-width: 768px)").matches) {
                //     var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                //         interval: false,
                //     });
                //     var carouselWidth = $(".carousel-inner")[0].scrollWidth;
                //     var cardWidth = $(".carousel-item").width();
                //     var scrollPosition = 0;
                //     $("#carouselExampleControls .carousel-control-next").on("click", function() {
                //         if (scrollPosition < carouselWidth - cardWidth * 4) {
                //             scrollPosition += cardWidth;
                //             $("#carouselExampleControls .carousel-inner").animate({
                //                     scrollLeft: scrollPosition
                //                 },
                //                 600
                //             );
                //         }
                //     });
                //     $("#carouselExampleControls .carousel-control-prev").on("click", function() {
                //         if (scrollPosition > 0) {
                //             scrollPosition -= cardWidth;
                //             $("#carouselExampleControls .carousel-inner").animate({
                //                     scrollLeft: scrollPosition
                //                 },
                //                 600
                //             );
                //         }
                //     });
                // } else {
                //     $(multipleCardCarousel).addClass("slide");
                // }
                // let a = `<div class="item">
            //                 <div class="card my-0">
            //                     <div class="card-body">
            //                         <div class="d-flex justify-content-between align-items-center">
            //                             <div
            //                                 class="
            //                       btn btn-xl btn-light-warning
            //                       text-warning
            //                       btn-circle
            //                     ">
            //                                 <i class="fas fa-barcode"></i>
            //                             </div>
            //                             <h3 class="">
            //                                 <span class="fs-2 ms-1 text-success font-weight-medium"> 44 OK</span>
            //                                 <span class="fs-2 ms-1 text-danger font-weight-medium"> / 55 NOK</span>
            //                             </h3>
            //                         </div>

            //                         <div class="progress mt-3">
            //                             <div class="progress-bar" role="progressbar" style="width: 100%"
            //                                 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
            //                         </div>
            //                         <h3 class="text-start mt-1">FPY: 25%</h3>
            //                     </div>
            //                 </div>
            //             </div>`;
                // var itemsMainDiv = ('.MultiCarousel');
                // var itemsDiv = ('.MultiCarousel-inner');
                // var itemWidth = "";
                // $('.leftLst, .rightLst').click(function() {
                //     var condition = $(this).hasClass("leftLst");
                //     if (condition)
                //         click(0, this);
                //     else
                //         click(1, this)
                // });
                // ResCarouselSize();
                // $(window).resize(function() {
                //     ResCarouselSize();
                // });
                // //this function define the size of the items
                // function ResCarouselSize() {
                //     var incno = 0;
                //     var dataItems = ("data-items");
                //     var itemClass = ('.item');
                //     var id = 0;
                //     var btnParentSb = '';
                //     var itemsSplit = '';
                //     var sampwidth = $(itemsMainDiv).width();
                //     var bodyWidth = $('body').width();
                //     $(itemsDiv).each(function() {
                //         id = id + 1;
                //         var itemNumbers = $(this).find(itemClass).length;
                //         btnParentSb = $(this).parent().attr(dataItems);
                //         itemsSplit = btnParentSb.split(',');
                //         $(this).parent().attr("id", "MultiCarousel" + id);
                //         if (bodyWidth >= 1200) {
                //             // alert(itemsSplit[1]);
                //             incno = itemsSplit[1];
                //             itemWidth = sampwidth / incno;
                //         } else if (bodyWidth >= 992) {
                //             incno = itemsSplit[1];
                //             itemWidth = sampwidth / incno;
                //         } else if (bodyWidth >= 768) {
                //             incno = itemsSplit[1];
                //             itemWidth = sampwidth / incno;
                //         } else {
                //             incno = itemsSplit[0];
                //             itemWidth = sampwidth / incno;
                //         }
                //         $(this).css({
                //             'transform': 'translateX(0px)',
                //             'width': itemWidth * itemNumbers
                //         });
                //         $(this).find(itemClass).each(function() {
                //             $(this).outerWidth(itemWidth);
                //         });

                //         $(".leftLst").addClass("over");
                //         $(".rightLst").removeClass("over");

                //     });
                // }
                // //this function used to move the items
                // function ResCarousel(e, el, s) {
                //     var leftBtn = ('.leftLst');
                //     var rightBtn = ('.rightLst');
                //     var translateXval = '';
                //     var divStyle = $(el + ' ' + itemsDiv).css('transform');
                //     var values = divStyle.match(/-?[\d\.]+/g);
                //     var xds = Math.abs(values[4]);
                //     if (e == 0) {
                //         translateXval = parseInt(xds) - parseInt(itemWidth * s);
                //         $(el + ' ' + rightBtn).removeClass("over");

                //         if (translateXval <= itemWidth / 2) {
                //             translateXval = 0;
                //             $(el + ' ' + leftBtn).addClass("over");
                //         }
                //     } else if (e == 1) {
                //         var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
                //         translateXval = parseInt(xds) + parseInt(itemWidth * s);
                //         $(el + ' ' + leftBtn).removeClass("over");

                //         if (translateXval >= itemsCondition - itemWidth / 2) {
                //             translateXval = itemsCondition;
                //             $(el + ' ' + rightBtn).addClass("over");
                //         }
                //     }
                //     $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
                // }
                // //It is used to get some elements from btn
                // function click(ell, ee) {
                //     var Parent = "#" + $(ee).parent().attr("id");
                //     var slide = $(Parent).attr("data-slide");
                //     ResCarousel(ell, Parent, slide);
                // }
                //alert();
                //console.log(response);
            });
        });
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
    </script>
@endpush
