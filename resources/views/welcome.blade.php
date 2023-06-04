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
                .MultiCarousel {
                    float: left;
                    overflow: hidden;
                    width: 100%;
                    position: relative;
                }

                .MultiCarousel .MultiCarousel-inner {
                    transition: 1s ease all;
                    float: left;
                }

                .MultiCarousel .MultiCarousel-inner .item {
                    float: left;
                }

                .MultiCarousel .MultiCarousel-inner .item>div {
                    margin: 5px;
                }

                /* btn carousel style */
                .MultiCarousel .leftLst,
                .MultiCarousel .rightLst {
                    position: absolute;
                    border-radius: 50%;
                    top: calc(50% - 20px);
                }

                .MultiCarousel .leftLst {
                    left: 0;
                }

                .MultiCarousel .rightLst {
                    right: 0;
                }

                .MultiCarousel .leftLst.over,
                .MultiCarousel .rightLst.over {
                    display: none;
                }
            </style>
            <div class="row">
                <div class="col-lg-12">
                    {{-- <div class="card bg-info w-100">
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
                            <div class="mt-3">
                                <div>
                                    <div class="input-group date" id="id_0">
                                        <input type="text" value="" class="form-control" name="datetimes" />
                                    </div>
                                    <h2 class="fs-8 text-white mb-0">au :$93,438.78</h2>
                                </div>
                                <div>
                                    <button class="btn btn-danger text-white" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">changer</button>
                                </div> <span class="text-white op-5">Monthly revenue</span>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Filtrage') }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" class="datepickers">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <label class="label-control" for="id_start_datetime">date, temps début:</label>
                                    </div>
                                    <div class="col">
                                        {{-- <div class="input-group date" id="id_0">
                                            <input type="text" value="" class="form-control" name="datetimes" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-2 align-items-center">
                                    <div class="col-md-4">
                                        <label class="label-control" for="id_start_datetime">date, temps fin:</label>
                                    </div>
                                    <div class="col">
                                        <div class="input-group date" id="id_1">
                                            <input type="text" value="" class="form-control"
                                                placeholder="DD/MM/YYYY hh:mm:ss" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row pt-2 align-items-center">
                                    <div class="col-auto">
                                        <label class="label-control" for="id_start_datetime">OF:</label>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control" placeholder=""
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <label class="label-control" for="id_start_datetime">Type:</label>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="text" value="" class="form-control" placeholder=""
                                                required />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                    </div> --}}
                    <div class="card">
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
                                    <input type="text" value="" class="form-control" name="datetimes" />
                                </div>
                                <div class="col-auto">
                                    <label for="inputField" class="col-form-label">OF</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="inputField">
                                </div>
                                <div class="col-auto">
                                    <label for="inputField" class="col-form-label">Type</label>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control" id="inputField">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">GO</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    {{-- <div class="card-group">
                        <div class="card" style="min-width:250px">
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
                            </div>
                        </div>
                        <div class="card" style="min-width:250px">
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
                                    <i class="fas fa-barcode"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    4396
                                    <span class="fs-2 ms-1 text-success font-weight-medium">Utilisateurs</span>
                                </h3>

                            </div>
                        </div>
                        <div class="card" style="min-width:250px">
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
                        <div class="card" style="min-width:250px">
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
                                    <i class="fas fa-wrench"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    835
                                    <span class="fs-2 ms-1 text-danger font-weight-medium">OF</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card" style="min-width:250px">
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
                                    <i class="fas fa-wrench"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    835
                                    <span class="fs-2 ms-1 text-danger font-weight-medium">OF</span>
                                </h3>
                            </div>
                        </div>
                        <div class="card" style="min-width:250px">
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
                                    <i class="fas fa-wrench"></i>
                                </span>
                                <h3 class="mt-3 pt-1 mb-0">
                                    835
                                    <span class="fs-2 ms-1 text-danger font-weight-medium">OF</span>
                                </h3>
                            </div>
                        </div>
                    </div> --}}
                    <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel" data-interval="1000">
                        <div class="MultiCarousel-inner">
                            <div class="item">
                                <div class="card my-0">
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
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="card my-0">
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
                                            <i class="fas fa-barcode"></i>
                                        </span>
                                        <h3 class="mt-3 pt-1 mb-0">
                                            4396
                                            <span class="fs-2 ms-1 text-success font-weight-medium">Utilisateurs</span>
                                        </h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary leftLst">
                            < </button>
                                <button class="btn btn-primary rightLst">></button>
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
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ __('Filtrage') }}</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="datepickers">
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="label-control" for="id_start_datetime">date, temps début:</label>
                            </div>
                            <div class="col">
                                {{-- <div class="input-group date" id="id_0">
                                    <input type="text" value="" class="form-control" name="datetimes" />
                                </div> --}}
                            </div>
                        </div>
                        <div class="row pt-2 align-items-center">
                            <div class="col-md-4">
                                <label class="label-control" for="id_start_datetime">date, temps fin:</label>
                            </div>
                            <div class="col">
                                <div class="input-group date" id="id_1">
                                    <input type="text" value="" class="form-control"
                                        placeholder="DD/MM/YYYY hh:mm:ss" required />
                                </div>
                            </div>
                        </div>
                        <div class="row pt-2 align-items-center">
                            <div class="col-auto">
                                <label class="label-control" for="id_start_datetime">OF:</label>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input type="text" value="" class="form-control" placeholder="" required />
                                </div>
                            </div>
                            <div class="col-auto">
                                <label class="label-control" for="id_start_datetime">Type:</label>
                            </div>
                            <div class="col">
                                <div class="input-group">
                                    <input type="text" value="" class="form-control" placeholder="" required />
                                </div>
                            </div>
                        </div>
                    </form>
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
        $(document).ready(function() {
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
                    console.log(btnParentSb);
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


            callAjax('GET', base_url + '/pluck/sections').done(function(response) {
                appendToSelect(response.data, "#section_id");
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
