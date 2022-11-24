<!--
=========================================================
* Soft UI Dashboard - v1.0.6
=========================================================

* Product Page: https://www.creative-tim.com/product/soft-ui-dashboard
* Copyright 2022 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body class="g-sidenav-show bg-gray-100">
    {{-- Global alert --}}
    <div class="alert-message">

    </div>
    {{-- End Global alert --}}
    {{-- @include('layouts.delete_modal') --}}
    @include('layouts.aside')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- End Navbar -->
        @yield('content')
        @include('layouts.delete_modal')
    </main>
    @include('layouts.scripts')
</body>

</html>
