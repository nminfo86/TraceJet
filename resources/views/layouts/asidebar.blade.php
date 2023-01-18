<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">{{ __('Dashboard') }}</span></a></li>
                <h6 class="text-uppercase text-muted pb-1">adm<span class="d-sm-none d-lg-inline">instration</span></h6>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/roles') }}" aria-expanded="false"><i
                            class="mdi mdi-account-settings-variant"></i><span class="hide-menu"> {{ __('Rôles') }}
                        </span></a>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('/users') }}" aria-expanded="false"><i class="mdi mdi-account-network"></i><span
                            class="hide-menu"> {{ __('Utilisateurs') }} </span></a>
                </li>
                <h6 class="text-uppercase text-muted pb-1 pt-2 hide-menu">{{ __('Produits') }}</h6>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('products') }}" aria-expanded="false"><i class="mdi mdi-book "></i><span
                            class="hide-menu">{{ __('Produits') }}</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('calibers') }}" aria-expanded="false"><i
                            class="mdi mdi-book-multiple-variant"></i><span
                            class="hide-menu">{{ __('Calibres') }}</span></a></li>
                <h6 class="text-uppercase text-muted pb-1 pt-2">{{ __('Production') }}</h6>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('ofs') }}" aria-expanded="false"><i class="mdi mdi-arrow-top-right"></i><span
                            class="hide-menu">{{ __('Ofs') }}</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ url('serial_numbers') }}" aria-expanded="false"><i
                            class="mdi mdi-barcode-scan"></i><span class="hide-menu">{{ __('List des NS') }}</span></a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
