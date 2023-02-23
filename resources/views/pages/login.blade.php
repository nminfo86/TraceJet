<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')


<body>
    <div class="row">
        <div class="col-6 border">

        </div>
        <div class="col-6">
            {{-- <table style="height: 100vh;">
                <tbody>
                    <tr>
                        <td class="">
                            <form method="POST" action="{{ url('authLogin') }}">
                                @csrf
                                @if (Session::has('error'))
                                    <div class="text-danger">
                                        {{ Session::get('error') }}
                                    </div>
                                @endif
                                <div class="form-group mb-3">
                                    <input type="text" placeholder="Username" id="username"
                                        class="form-control @if ($errors->has('username')) is-invalid @endif w-100"
                                        name="username" autofocus>
                                    @if ($errors->has('username'))
                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mb-3">
                                    <input type="password" placeholder="Password" id="password"
                                        class="form-control @if ($errors->has('password')) is-invalid @endif w-100"
                                        name="password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                                        in</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                </tbody>

            </table> --}}
            <div class="container-fluid d-flex justify-content-center align-items-center"
                style="height:100vh; overflow:hidden;">

                <!-- Inner row, half the width and height, centered, blue border -->
                <div class="row text-center d-flex align-items-center" style="overflow:hidden; width:50vw; height:50vh;">

                    <!-- Innermost text, wraps automatically, automatically centered -->
                    <form method="POST" action="{{ url('authLogin') }}">
                        @csrf
                        @if (Session::has('error'))
                            <div class="text-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <input type="text" placeholder="Username" id="username"
                                class="form-control @if ($errors->has('username')) is-invalid @endif w-auto mx-auto"
                                name="username" autofocus>
                            @if ($errors->has('username'))
                                <span class="text-danger">{{ $errors->first('username') }}</span>
                            @endif
                        </div>
                        <div class="form-group mb-3">
                            <input type="password" placeholder="Password" id="password"
                                class="form-control @if ($errors->has('password')) is-invalid @endif w-auto mx-auto"
                                name="password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="text-center">
                            <button type="submit"
                                class="btn bg-info w-auto mx-auto mt-4 mb-0">{{ __('Se connecter') }}</button>
                        </div>
                    </form>

                </div> <!-- Inner row -->
            </div> <!-- Outer container -->
        </div>


    </div>

</body>
@include('layouts.script')

</html>
