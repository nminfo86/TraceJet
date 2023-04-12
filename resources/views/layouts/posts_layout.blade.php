<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body>
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
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        {{-- @include('layouts.navbar') --}}
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        {{-- @include('layouts.asidebar') --}}
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            {{-- <div class="page-breadcrumb">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0 d-flex align-items-center">
                                <li class="breadcrumb-item"><a href="index.html" class="link"><i
                                            class="mdi mdi-home-outline fs-4"></i></a></li>
                                {{-- <li class="breadcrumb-item active" aria-current="page">Starter Page</li> --
                                @yield('breadcrumb')
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6">
                        @yield('btns_actions')
                    </div>
                </div>
            </div> --}}
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid bg-light" style="min-height: 100vh">
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div style="position:fixed;top:0;right:0;z-index:1000"><a href="{{ url('logout') }}"
                        class="btn btn-circle btn-danger me-2 mt-2"><i
                            class="fa fa-sign-out-alt m-r-5 m-l-5 text-white"></i></a>
                </div>




                <!-- -------------------------------------------------------------------------- -->
                <!--                          Clock + post name                                 -->
                <!-- -------------------------------------------------------------------------- -->
                <div class="row ">
                    <div class="d-flex justify-content-between fixed-bottom bg-cyan  text-white pb-1 z-index-100 fs-3 ">
                        <div style="/*position:fixed;bottom:2%;left:1%;z-index:1000*/">

                            {{-- <i class="fa fa-sign-out-alt m-r-5 m-l-5 text-white"></i> --}}
                            <span class="">{{ Auth::user()->username }}</span>



                        </div>
                        <div style="/*position:fixed;bottom:2%;left:45%;z-index:1000*/">

                            {{-- <i class="fa fa-sign-out-alt m-r-5 m-l-5 text-white"></i> --}}
                            <span id="clock" class=" "></span>



                        </div>
                        <div style="/*position:fixed;bottom:2%;right:2%;z-index:1000*/">

                            {{-- <i class="fa fa-sign-out-alt m-r-5 m-l-5 text-white"></i> --}}
                            <span class="  ">{{ Session::get('user_data')['post_information']['post_name'] }}</span>
                        </div>

                    </div>
                </div>

                {{-- <div id="navbar" class="navbar navbar-fixed-top navbar-right">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="">Contact Us</a></li>
                        <li><a href="">NL</a></li>
                        <li><a href="">ENG</a></li>
                    </ul>
                </div> --}}
                @yield('content')
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            {{-- @include('layouts.footer') --}}
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>

    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    @include('layouts.script')
</body>

</html>
