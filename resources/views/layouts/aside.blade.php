<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-search pt-5">
            <select name="authority" id="authority" class="form-control">

            </select>
        </div>
        {{-- <div class="pcoded-navigatio-lavel" data-i18n="nav.category.navigation">Leadership</div>
        <ul class="pcoded-item pcoded-left-item">

            <li class="">
                <a href="Home/process">
                    <span class="pcoded-micon"><i class="ti-home"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">Processus</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-layout-grid2-alt"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.main">Responsabilté
                        &amp; autorité</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class=" ">
                        <a href="Home/responsability">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Responsabilité</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class=" ">
                        <a href="Home/authority">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext" data-i18n="nav.basic-components.breadcrumbs">Autorité</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class=" ">
                <a href="Home/overall_goals">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Objectifs
                        globaux</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class=" ">
                <a href="Home/policy">
                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                    <span class="pcoded-mtext" data-i18n="nav.basic-components.alert">Politique
                        SMI</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
            <li class="">
                <a href="Home/cartography">
                    <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.dash.main">cartographie</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul> --}}
        <div class="pcoded-navigatio-lavel" data-i18n="nav.category.forms">{{ __('Administration') }}</div>
        <ul class="pcoded-item pcoded-left-item">
            <li>
                <a href="{{ url('users') }}">
                    <span class="pcoded-micon"><i class="ti-user"></i><b>U</b></span>
                    <span class="pcoded-mtext" data-i18n="nav.form-components.main">{{ __('Utilisateurs') }}</span>
                    <span class="pcoded-mcaret"></span>
                </a>
            </li>
        </ul>
    </div>
</nav>
