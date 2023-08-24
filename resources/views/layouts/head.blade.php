<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('trac') }}</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/Flexy-admin-lite/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('/assets/images/favicon.png') }}">

    <link href="{{ asset('/dist/css/datatables.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->

    <link href="{{ asset('/dist/css/icons/font-awesome/css/fontawesome-all.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/icons/material-design-iconic-font/css/materialdesignicons.min.css') }}"
        rel="stylesheet">
    <link href="{{ asset('/dist/css/icons/themify-icons/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/icons/weather-icons/css/weather-icons.min.css') }}" rel="stylesheet">

    {{-- <link href="https://demos.wrappixel.com/premium-admin-templates/bootstrap/flexy-bootstrap/package/dist/css/style.min.css"
        rel="stylesheet" /> --}}
    @if (Config::get('app.locale') == 'ar')
        <link href="{{ asset('/dist/css/style-rtl.min.css') }}" rel="stylesheet">
    @else
        <link href="{{ asset('/dist/css/style.min.css') }}" rel="stylesheet">
    @endif
    <link href="{{ asset('/dist/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('/dist/css/select2-bootstrap-5-theme.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/dist/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/daterangepicker.css') }}">
    {{-- <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'> --}}
    <style>
        .table>tbody {
            cursor: pointer
        }
    </style>
    @stack('css')
