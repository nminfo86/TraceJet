<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')


<body>
    <div class="row">
        <div class="col-md-6 border" style="background-image:url('{{ asset('assets/images/pxfuel.jpg') }}');">
            {{-- <img src="{{ asset('assets/images/login.png') }}" alt="" srcset=""> --}}
        </div>
        <div class="col-md-6">
            <div class="container-fluid d-flex justify-content-center align-items-center"
                style="height:100vh; overflow:hidden;">

                <!-- Inner row, half the width and height, centered, blue border -->
                <div class="row d-flex">

                    <!-- Innermost text, wraps automatically, automatically centered -->
                    <form method="POST" action="{{ url('authLogin') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="username" class=""> {{ __("Nom d'utilisateur") }}</label>
                            <input type="text" placeholder="Username" id="username"
                                class="form-control @if ($errors->has('username')) is-invalid @endif  mx-auto"
                                name="username" autofocus style="min-width: 300px">
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <label for="password"> {{ __('mot de passe') }}</label>
                            <input type="password" placeholder="Password" id="password"
                                class="form-control @if ($errors->has('password')) is-invalid @endif  mx-auto"
                                name="password" style="min-width: 300px">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="text-center" style="max-width: 300px">
                            @if (Session::has('error'))
                                <div class="text-danger">
                                    {{ __(Session::get('error')) }}
                                </div>
                            @endif
                        </div>
                        <div class="">
                            <button type="submit"
                                class="btn bg-info text-white w-100  mt-4 mb-0">{{ __('Se connecter') }}</button>
                        </div>
                    </form>

                </div> <!-- Inner row -->
            </div> <!-- Outer container -->
        </div>
    </div>
</body>
@include('layouts.script')

</html>
