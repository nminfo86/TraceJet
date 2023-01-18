<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')
{{-- <style>
    body {
        font-family: "Lato", sans-serif;
    }



    .main-head {
        height: 150px;
        background: #FFF;

    }

    .sidenav {
        height: 100%;
        background-color: #000;
        overflow-x: hidden;
        padding-top: 20px;
    }


    .main {
        padding: 0px 10px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
        }
    }

    @media screen and (max-width: 450px) {
        .login-form {
            margin-top: 10%;
        }

        .register-form {
            margin-top: 10%;
        }
    }

    @media screen and (min-width: 768px) {
        .main {
            margin-left: 40%;
        }

        .sidenav {
            width: 40%;
            position: fixed;
            z-index: 1;
            top: 0;
            left: 0;
        }

        .login-form {
            margin-top: 80%;
        }

        .register-form {
            margin-top: 20%;
        }
    }


    .login-main-text {
        margin-top: 20%;
        padding: 60px;
        color: #fff;
    }

    .login-main-text h2 {
        font-weight: 300;
    }

    .btn-black {
        background-color: #000 !important;
        color: #fff;
    }
</style> --}}

<body>
    {{-- <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ url('authLogin') }}">
                                        @if (Session::has('error'))
                                            <div class="text-danger">
                                                {{ Session::get('error') }}
                                            </div>
                                        @endif
                                        <div class="form-group mb-3">
                                            <input type="text" placeholder="Username" id="username"
                                                class="form-control @if ($errors->has('username')) is-invalid @endif"
                                                name="username" autofocus>
                                            @if ($errors->has('username'))
                                                <span class="text-danger">{{ $errors->first('username') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" placeholder="Password" id="password"
                                                class="form-control @if ($errors->has('password')) is-invalid @endif"
                                                name="password">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="rememberMe"
                                                checked="">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>

                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>

                                    </form>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Don't have an account?
                                        <a href="javascript:;" class="text-info text-gradient font-weight-bold">Sign
                                            up</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute  h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                    style='background-image:url("{{ asset('assets/img/curved-images/curved6.jpg') }}"'>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main> --}}
    {{-- <div class="sidenav">
        <div class="login-main-text">
            <h2>Application<br> Login Page</h2>
            <p>Login or register from here to access.</p>
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">
            <div class="login-form">
                <form>
                    <div class="form-group">
                        <label>User Name</label>
                        <input type="text" class="form-control" placeholder="User Name">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-black">Login</button>
                    <button type="submit" class="btn btn-secondary">Register</button>
                </form>
            </div>
        </div>
    </div> --}}
    {{-- <div class="row align-middle">
        <div class="col-lg-6">
            <form method="POST" action="{{ url('authLogin') }}">
                @if (Session::has('error'))
                    <div class="text-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="form-group mb-3">
                    <input type="text" placeholder="Username" id="username"
                        class="form-control @if ($errors->has('username')) is-invalid @endif" name="username"
                        autofocus>
                    @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <input type="password" placeholder="Password" id="password"
                        class="form-control @if ($errors->has('password')) is-invalid @endif" name="password">
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                        in</button>
                </div>

            </form>
        </div>

    </div> --}}
    <div class="row">
        <div class="col-6">

        </div>
        <div class="col-6 border d-flex align-items-center" style="height: 100vh;">
            <form method="POST" action="{{ url('authLogin') }}">
                @csrf
                @if (Session::has('error'))
                    <div class="text-danger">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <div class="form-group mb-3">
                    <input type="text" placeholder="Username" id="username"
                        class="form-control @if ($errors->has('username')) is-invalid @endif" name="username"
                        autofocus>
                    @if ($errors->has('username'))
                        <span class="text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-group mb-3">
                    <input type="password" placeholder="Password" id="password"
                        class="form-control @if ($errors->has('password')) is-invalid @endif" name="password">
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rememberMe" checked="">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                        in</button>
                </div>
            </form>
        </div>
    </div>



</body>
@include('layouts.script')

</html>
