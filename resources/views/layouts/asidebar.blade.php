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
                        href="{{ url('/dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span
                            class="hide-menu">{{ __('Dashboard') }}</span></a></li>
                @can('role-list')
                    <h6 class="text-uppercase text-muted pb-1 pt-2 text-truncate">{{ __('administration') }}</h6>
                @elsecan('user-list')
                    <h6 class="text-uppercase text-muted pb-1 pt-2 text-truncate">{{ __('administration') }}</h6>
                @endcan
                @can('role-list')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link text-capitalize"
                            href="{{ url('/roles') }}" aria-expanded="false"><i class="mdi mdi-account-settings"></i><span
                                class="hide-menu"> {{ __('rôles') }}
                            </span></a>
                    </li>
                @endcan
                @can('user-list')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link text-capitalize"
                            href="{{ url('/users') }}" aria-expanded="false"><i class="mdi mdi-account-network"></i><span
                                class="hide-menu"> {{ __('utilisateurs') }} </span></a>
                    </li>
                @endcan
                @can('user-list')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                            href="{{ url('hosts') }}" aria-expanded="false"><i class="mdi mdi-account-network"></i><span
                                class="hide-menu"> {{ __('Hosts') }} </span></a>
                    </li>
                @endcan
                {{-- <h6 class="text-uppercase text-muted pb-1 pt-2 hide-menu text-truncate">{{ __('Produits') }}</h6> --}}
                @can('product-list')
                    <h6 class="text-uppercase text-muted pb-1 pt-2 text-truncate ">{{ __('produits') }}</h6>
                @elsecan('caliber-list')
                    <h6 class="text-uppercase text-muted pb-1 pt-2 text-truncate ">{{ __('produits') }}</h6>
                @endcan
                @can('product-list')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link text-capitalize"
                            href="{{ url('products') }}" aria-expanded="false"><i class="mdi mdi-book "></i><span
                                class="hide-menu">{{ __('produits') }}</span></a></li>
                @endcan
                @can('caliber-list')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link text-capitalize"
                            href="{{ url('calibers') }}" aria-expanded="false"><i class="mdi mdi-book-multiple"></i><span
                                class="hide-menu">{{ __('calibres') }}</span></a></li>
                @endcan
                @can('of-list')
                    <h6 class="text-uppercase text-muted pb-1 pt-2 text-truncate text-capitalize">{{ __('production') }}
                    </h6>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link text-capitalize"
                            href="{{ url('ofs') }}" aria-expanded="false"><i class="mdi mdi-arrow-top-right"></i><span
                                class="hide-menu">{{ __('OFs') }}</span></a></li>
                @endcan
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link text-capitalize"
                        href="{{ url('serial_numbers') }}" aria-expanded="false"><i
                            class="mdi mdi-barcode-scan"></i><span class="hide-menu">{{ __('list des NS') }}</span></a>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link text-capitalize"
                        href="{{ url('packaging') }}" aria-expanded="false"><i class="mdi mdi-box"></i><span
                            class="hide-menu">{{ __('emballage') }}</span></a>
                </li>
                <div></div>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
