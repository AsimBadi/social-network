<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title')</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
</head>

<body class="with-welcome-text">
    <div class="container-scroller">
        <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
                <div class="me-3">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                        data-bs-toggle="minimize">
                        <span class="icon-menu"></span>
                    </button>
                </div>
                <div>
                    <a class="navbar-brand brand-logo" href="">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" />
                    </a>
                    <a class="navbar-brand brand-logo-mini" href="">
                        <img src="{{ asset('assets/images/logo-mini.svg') }}" alt="logo" />
                    </a>
                </div>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-top">
                <ul class="navbar-nav">
                    <li class="nav-item fw-semibold d-none d-lg-block ms-0">
                        <h1 class="welcome-text"><span class="text-black fw-bold">@yield('page-name')</span></h1>
                        <h3 class="welcome-sub-text">@yield('page-title')</h3>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item d-none d-lg-block">
                        <div class="input-group">
                            <form action="" method="POST">
                                {{-- <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script> --}}
                                @csrf
                                <button class="btn btn-danger" type="submit">Logout</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper">

            @include('front-end.partials.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="row grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    @yield('content')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/vendors/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
<script src="{{ asset('assets/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>
<script src="{{ asset('assets/js/settings.js') }}"></script>
<script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/js/todolist.js') }}"></script>
<script src="{{ asset('assets/js/jquery.cookie.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/js/file-upload.js') }}"></script>
<script src="{{ asset('assets/js/typeahead.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

@stack('js')

</html>
