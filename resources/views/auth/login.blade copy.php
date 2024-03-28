
<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>Mirmaz Academy</title>
    <link rel="apple-touch-icon" href="{{ asset('app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('app-assets/images/ico/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/vendors-rtl.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/pages/page-auth.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css-rtl/custom-rtl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style-rtl.css')}}">
    <!-- END: Custom CSS-->


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v2">
                    <div class="auth-inner row m-0">
                        <!-- Brand logo--><a class="brand-logo" href="javascript:void(0);">

                            <h2 class="brand-text text-primary mr-6">Mirmaz Academy</h2>
                        </a>
                        <!-- /Brand logo-->
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" style="background: #ffffff">
                            @if($type == 'teachers')
                                 <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" style="max-width: 135%!important;" src="{{ asset('mirmaz.png') }}" alt="Login V2" /></div>
                            @else
                                 <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" style="max-width: 135%!important;" src="{{ asset('tecno.jpg') }}" alt="Login V2" /></div>
                            @endif
                        </div>

                        <!-- /Left Text-->
                        <!-- Login-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">

                                @if($type == 'teachers')
                                    <h3 style="font-family: 'Cairo', sans-serif" align="center">  لوحة دخول الأستاذ</h3>
                                @else
                                    <h3 style="font-family: 'Cairo', sans-serif" align="center" >  لوحة دخول الادمن </h3>
                                @endif
                                {{-- <h2 class="card-title font-weight-bold mb-1">Welcome to Mirmaz Academy </h2> --}}

                                <form class="auth-login-form mt-2"  method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <input type="hidden" value="{{$type}}" name="type">
                                    <div class="form-group">
                                        <label class="form-label" for="login-email">Email</label>
                                        <input type="text" id="username" class="form-control @error('username') is-invalid @enderror" id="login-email" name="email" value="{{ old('email') }}" placeholder="john@example.com" aria-describedby="login-email" tabindex="1" required autocomplete="email" autofocus />
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>

                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="login-email">Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">

                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror form-control-merge" name="password" required autocomplete="current-password"  tabindex="2" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="login-password" />
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                             @enderror
                                            <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Login') }}
                                    </button>
                                </form>

                            </div>
                        </div>
                        <!-- /Login-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset("app-assets/vendors/js/vendors.min.js")}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset("app-assets/vendors/js/forms/validation/jquery.validate.min.js")}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset("app-assets/js/core/app-menu.js")}}"></script>
    <script src="{{ asset("app-assets/js/core/app.js")}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset("app-assets/js/scripts/pages/page-auth-login.js")}}"></script>
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>
