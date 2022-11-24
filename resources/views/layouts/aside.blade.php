<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html "
            target="_blank">
            <img src="../assets/img/logo-ct-dark.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold">Soft UI Dashboard</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="../pages/dashboard.html">
                    <i
                        class="fa fa-tachometer icon icon-shape icon-sm shadow border-radius-md bg-white text-center ms-2 d-flex align-items-center justify-content-center"></i>

                    <span class="nav-link-text ms-1">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('meals') ? 'active' : '' }}" href="{{ url('meals') }}">
                    <div>
                        <i
                            class="fa fa-cutlery icon icon-shape icon-sm shadow border-radius-md bg-white text-center ms-2 d-flex align-items-center justify-content-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('food') ? 'active' : '' }}" href="{{ url('food') }}">
                    <div>
                        <i
                            class="fas fa-box-open icon icon-shape icon-sm shadow border-radius-md bg-white text-center ms-2 d-flex align-items-center justify-content-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->is('beneficiaries') ? 'active' : '' }}"
                    href="{{ url('beneficiaries') }}">
                    <i
                        class="fa fa-users icon icon-shape icon-sm shadow border-radius-md bg-white text-center ms-2 d-flex align-items-center justify-content-center"></i>
                    <span class="nav-link-text ms-1">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link " href="../pages/tables.html">
                    <div>
                        <i
                            class="fa fa-users icon icon-shape icon-sm shadow border-radius-md bg-white text-center ms-2 d-flex align-items-center justify-content-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">{{ __('Statistics') }}</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
        <div class="card card-background shadow-none card-background-mask-secondary" id="sidenavCard">
            <div class="full-background" style="background-image: url('../assets/img/curved-images/white-curved.jpg')">
            </div>
            <div class="card-body text-start p-3 w-100">
                <div
                    class="icon icon-shape icon-sm bg-white shadow text-center mb-3 d-flex align-items-center justify-content-center border-radius-md">
                    <i class="ni ni-diamond text-dark text-gradient text-lg top-0" aria-hidden="true"
                        id="sidenavCardIcon"></i>
                </div>
                <div class="docs-info">
                    <h6 class="text-white up mb-0">Need help?</h6>
                    <p class="text-xs font-weight-bold">Please check our docs</p>
                    <a href="https://www.creative-tim.com/learning-lab/bootstrap/license/soft-ui-dashboard"
                        target="_blank" class="btn btn-white btn-sm w-100 mb-0">Documentation</a>
                </div>
            </div>
        </div>
    </div>
</aside>
