<!DOCTYPE html>
<html class="loading light-layout" lang="en" data-layout="dark-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Mirmaz Academy</title>
    <link rel="apple-touch-icon" href="{{asset('image/logo.png')}}">
    <?php $image = \App\Models\Setting::where('id',1)->first(); ?>
    <link rel="shortcut icon" type="image/x-icon" href=" {{ $image->image }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/dark-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/bordered-layout.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/themes/semi-dark-layout.css')}}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/plugins/forms/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/page-auth.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!-- END: Custom CSS-->
    <style>
        .brand-logo img{
            width: 200px;
        }
        .form-control:focus {
            color: #6E6B7B;
            background-color: #171a40 !important;
            border-color: #171a40 !important;
            outline: 0;
            box-shadow: 0 3px 10px 0 rgb(34 41 47 / 10%);
        }
        .btn-primary {
            border-color: #171a40 !important;
            background-color: #171a40  !important;
            color: #FFFFFF !important;
        }
        .btn-primary:hover:not(.disabled):not(:disabled) {
            box-shadow: 0 8px 25px -8px #171a40 !important;
        }
        .btn-primary:focus, .btn-primary:active, .btn-primary.active {
            color: #FFFFFF;
            background-color: #171a40 !important;
        }
    </style>
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
                        {{-- <img src="{{asset('14511.svg')}}" alt=""> --}}
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5" style="background: #171a40;">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                            <img class="img-fluid" src="{{asset('login-v2.svg')}}" alt="Login V2" />
                        </div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title font-weight-bold mb-1" style="text-align: center">
                             @if($type == 'teachers')
                                <img src="{{ asset('Artboard 1@4x-8.png') }}" style="width:50%" alt="">
                                {{-- <h3 style="font-family: 'Cairo', sans-serif" align="center">  تسجيل الدخول كأستاذ</h3> --}}
                                <h3 style="font-family: 'Cairo', sans-serif" align="center">  تسجيل الدخول كأستاذ</h3>
                            @else
                                <img src="{{ asset('Artboard 1@4x-8.png') }}" style="width:50%" alt="">
                                {{-- <h3 style="font-family: 'Cairo', sans-serif" align="center" > تسجيل الدخول كمسؤول </h3> --}}
                                <h3 style="font-family: 'Cairo', sans-serif" align="center" > تسجيل الدخول  </h3>
                            @endif</h2>

                            <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                                @csrf
                                <input type="hidden" value="{{$type}}" name="type">
                                @error('generic')
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @enderror


                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                <div class="form-group">
                                    <label class="form-label" for="login-email">البريد الالكتروني</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="login-email"
                                           type="text" name="email" placeholder="john@example.com" aria-describedby="login-email" value="{{ old('email') }}" autofocus="" tabindex="1" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label for="login-password">كلمة المرور</label>

                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="login-password" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" />
                                        <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
{{--                                <div class="form-group">--}}
{{--                                    <div class="custom-control custom-checkbox">--}}
{{--                                        <input class="custom-control-input" id="remember" type="checkbox" tabindex="3" />--}}
{{--                                        <label class="custom-control-label" for="remember-me">{{ __('Remember Me') }}</label>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <button class="btn btn-primary btn-block" tabindex="4">{{__('Sign in')}}</button>
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
<script src="{{asset('')}}app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('')}}app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{asset('')}}app-assets/js/core/app-menu.js"></script>
<script src="{{asset('')}}app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{asset('')}}app-assets/js/scripts/pages/page-auth-login.js"></script>
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
