<!DOCTYPE html>
<html @if (Config::get('app.locale') == 'ar') dir="rtl" @endif lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body style="background-color: red !important">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="horizontal" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid" style="min-height: 100vh">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div style="position:fixed;top:0;right:0;z-index:1000">
                    <span> <button class="btn btn-info btn-circle me-2 mt-2 text-white pt-1" type="button"
                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ LaravelLocalization::getCurrentLocale() }}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                <li>
                                    <a class="ms-2" rel="alternate" hreflang="{{ $localeCode }}"
                                        href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                        {{ $properties['native'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </span>
                    <span>
                        {{-- <a href="{{ url('logout') }}" class="btn btn-circle btn-danger me-2 mt-2"><i
                                class="fa fa-sign-out-alt ps-1 pt-0 text-white"></i></a> --}}
                        <a class="btn btn-danger btn-circle me-2 mt-2 text-white pt-1" href="{{ url('logout') }}">
                            <i class="fa fa-sign-out-alt text-white mt-1 fs-4"></i>
                        </a>
                    </span>
                </div>
                <div class="row d-flex align-items-stretch">
                    <div class="col-lg-6 flex-fill">
                        <div class="row">

                            {{-- Packaging --}}
                            <div class="col-12">
                                <div class="card shadow border-primary">
                                    <div class="card-body">
                                        <div class=" row">
                                            <form id="main_form">
                                                <div class="row mx-0">
                                                    <label for="inputPassword" class="col-md-1 "><i
                                                            class="mdi mdi-24px mdi-barcode-scan"></i></label>
                                                    <div class="col-md-11">
                                                        <input type="text" class="form-control bg-light"
                                                            id="qr" name="qr" onblur="this.focus()"
                                                            autofocus>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong id="qr-error"></strong>
                                                        </span>
                                                        <div class="text-center h4 pt-2" id="scanned_qr"> Scanner un
                                                            produit
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="submit" class="d-none">
                                            </form>
                                            <hr class="of_number  mt-2" />
                                            <div class="col-12 d-flex justify-content-between  of_number ">
                                                <div class="">
                                                    <h5 class="fw-n"> {{ __('Etat OF') }} : <span
                                                            class="badge bg-primary fs-4 font-weight-normal"
                                                            id="status"></span>
                                                    </h5>
                                                </div>
                                                <div class="">
                                                    <h5> {{ __('OF Numéro') }} : <span id="of_number"
                                                            class="fs-3 font-weight-medium badge bg-primary text-white"></span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6  of_number ">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('N° de serie') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-info ms-2"
                                                        id="serial_number"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6  of_number ">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('N° de carton') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-info ms-2"
                                                        id="box_number"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6  mt-4 ">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('Qt PCS/ Carton') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-info ms-2"
                                                        id="box_quantity"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6  mt-4 ">
                                                <div class="col-12 border-start border-secondary float-start ">
                                                    <h6 class="fw-normal text-muted mb-0 ms-2">
                                                        {{ __('Etat carton') }}</h6>
                                                    <span class="fs-1 font-weight-medium text-info ms-2"
                                                        id="box_status"></span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                </div>
                            </div>


                            <div class="col-12 {{ request()->segment(2) == 'repairs' ? '' : 'd-none' }} of_info ">
                                <div class="card shadow border-primary">
                                    <div class="card-body">
                                        <div class="table-responsive">

                                            <div class="row border-bottom mt-2 gx-0 mx-0">
                                                <div class="col-4 pb-3 border-end">
                                                    <h6 class="fw-normal fs-5 mb-0">{{ __('Date lancement') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-primary"
                                                        id="release_date"></span>
                                                </div>
                                                <div class="col-4 pb-3 border-end ps-3">
                                                    <h6 class="fw-normal fs-5 mb-0">{{ __('Produit') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-primary"
                                                        id="product_name"></span>
                                                </div>
                                                <div class="col-4 pb-3 border-end ps-3">
                                                    <h6 class="fw-normal fs-5 mb-0">{{ __('Calibre') }}</h6>
                                                    <span class="fs-3 font-weight-medium text-primary "
                                                        id="caliber_name"></span>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-2 mx-0">
                                                <div class="row col-12 text-center">
                                                    <div class="outer mx-auto">
                                                        <canvas id="chartJSContainer" width="auto"
                                                            height="auto"></canvas>
                                                        <p class="percent" id="percent"></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 flex-fill of_info">
                        <div class="card shadow border-primary" style="min-height: 90vh">
                            <div class="card-body text-white">
                                <div class="table-responsive">
                                    <table id="main_table" class="table table-sm table-hover  " width="100%">
                                        <thead class="bg-light">
                                            <tr>
                                                <td>SN</td>
                                                <td>Etat</td>
                                                <td>Created At</td>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Container fluid  -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- footer -->
                <!-- ============================================================== -->
                <div class="row ">
                    <div
                        class="d-flex justify-content-between fixed-bottom bg-cyan  text-white pb-1 z-index-100 fs-4 ">
                        <div style="/*position:fixed;bottom:2%;left:1%;z-index:1000*/">
                            <span class="">{{ Auth::user()->username }} </span>
                        </div>
                        <div style="/*position:fixed;bottom:2%;right:2%;z-index:1000*/">
                            {{-- <span class="  ">{{ Session::get('user_data')['post_information']['post_name'] }}</span> --}}
                            <span class="">{{ Session::get('post_information')['post_name'] ?? '' }}
                            </span>
                        </div>

                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End footer -->
                <!-- ============================================================== -->

            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->
        </div>
        <div id="qr_code"></div>

        <!-- ============================================================== -->
        <!-- End Wrapper -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- All Jquery -->
        <!-- ============================================================== -->
        <script src="{{ asset('/dist/js/chart/chart.min.js') }}"></script>

        @include('layouts.script')
</body>

</html>
