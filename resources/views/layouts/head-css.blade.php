@yield('css')

<!-- Bootstrap Css -->
<link href="{{ URL::asset('/build/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ URL::asset('/build/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ URL::asset('/build/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="{{ URL::asset('/build/libs/toastr/build/toastr.min.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
