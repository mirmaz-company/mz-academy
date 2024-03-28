<!DOCTYPE html>
<html lang="ar" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Traip">
        <meta name="keywords" content="HTML,CSS,JavaScript">
        <meta name="author" content="EnvyTheme">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <title>Traip - Travel & Tour Booking HTML Template</title>
        <link rel="icon" href="{{ asset('front/assets/images/favicon.png')}}')}}" type="image/png" sizes="16x16">

        <!-- bootstrap css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.rtl.min.css')}}" type="text/css" media="all" />
        <!-- animate css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/animate.min.css')}}" type="text/css" media="all" />
        <!-- owl carousel css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/owl.carousel.min.css')}}"  type="text/css" media="all" />
        <link rel="stylesheet" href="{{ asset('front/assets/css/owl.theme.default.min.css')}}"  type="text/css" media="all" />
        <!-- meanmenu css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/meanmenu.min.css')}}" type="text/css" media="all" />
        <!-- jquery ui css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/jquery-ui.min.css')}}" type="text/css" media="all" />
        <!-- selectize css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/selectize.min.css')}}" type="text/css" media="all" />
        <!-- magnific popup css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/magnific-popup.min.css')}}" type="text/css" media="all" />
        <!-- icofont css -->
        <link rel='stylesheet' href='{{ asset('front/assets/css/icofont.min.css')}}' type="text/css" media="all" />
        <!-- flaticon css -->
        <link rel='stylesheet' href="{{ asset('front/assets/css/flaticon.css')}}" type="text/css" media="all" />
        <!-- style css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/style.css')}}" type="text/css" media="all" />
        <!-- responsive css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/responsive.css')}}" type="text/css" media="all" />
        <!-- rtl css -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/rtl.css')}}" type="text/css" media="all" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" type="text/css" media="all" />

        <!-- Magnific Popup core CSS file -->
        <link rel="stylesheet" href="{{ asset('magnific/magnific-popup.css')}}">

        
    </head>

    <body class="homepage-2">
        <!-- preloader -->
        <div class="preloader">
            <div class="preloader-wrapper">
                <div class="preloader-grid">
                    <div class="preloader-grid-item preloader-grid-item-1"></div>
                    <div class="preloader-grid-item preloader-grid-item-2"></div>
                    <div class="preloader-grid-item preloader-grid-item-3"></div>
                    <div class="preloader-grid-item preloader-grid-item-4"></div>
                    <div class="preloader-grid-item preloader-grid-item-5"></div>
                    <div class="preloader-grid-item preloader-grid-item-6"></div>
                    <div class="preloader-grid-item preloader-grid-item-7"></div>
                    <div class="preloader-grid-item preloader-grid-item-8"></div>
                    <div class="preloader-grid-item preloader-grid-item-9"></div>
                </div>
            </div>
        </div>
        <!-- .end preloader -->
        <!-- preloader -->
        <div class="preloader">
            <div class="preloader-wrapper">
                <div class="preloader-grid">
                    <div class="preloader-grid-item preloader-grid-item-1"></div>
                    <div class="preloader-grid-item preloader-grid-item-2"></div>
                    <div class="preloader-grid-item preloader-grid-item-3"></div>
                    <div class="preloader-grid-item preloader-grid-item-4"></div>
                    <div class="preloader-grid-item preloader-grid-item-5"></div>
                    <div class="preloader-grid-item preloader-grid-item-6"></div>
                    <div class="preloader-grid-item preloader-grid-item-7"></div>
                    <div class="preloader-grid-item preloader-grid-item-8"></div>
                    <div class="preloader-grid-item preloader-grid-item-9"></div>
                </div>
            </div>
        </div>
  
       

           <!-- Authentication -->
           <div class="authentication-section pb-100 position-relative">
            <div class="map-shapes d-none d-md-block">
                <div class="map-shape map-shape-2 map-shape-vertical-top">
                    <img src="{{ asset('front/assets/images/shapes/map-2.png') }}" alt="shape">
                </div>
            </div>
            <div class="container">
                <div class="authentication-header mb-30">
                <h1 class="text-center">Login  <a href="{{ route('ships_register') }}" style="font-size: 16px">(Register)</a></h1>
               
                </div>
                <div class="authentication-form-box">
                    <div class="authentication-form-box-item active" data-authentication-item="1">
                        <div class="authentication-box">
                            <div class="authentication-box-inner">
                                <form  method="POST" action="{{ route('login') }}" class="authentication-form mb-20">
                                    @csrf
                                
                                    <div class="input-group input-group-bg mb-20">
                                        <input type="email" class="form-control" name="email" placeholder="Email Address" aria-label="Email">
                                    </div>
                                  
                                    <div class="input-group input-group-bg mb-20">
                                        <input type="password" class="form-control" name="password" placeholder="Enter Password" aria-label="password">
                                    </div>
                                  
                                    <button type="submit" id="add_user" class="btn main-btn main-btn-lg full-width">login</button>
                                    {{-- <button type="button" id="add_user" class="btn btn-primary btn-block">اضافة</button> --}}
                                </form>
                                <div class="authentication-divider">
                                    {{-- <span>OR</span> --}}
                                </div>
                         
                            </div>
                        </div>
                    </div>
                    <div class="authentication-form-box-item" data-authentication-item="2">
                        <div class="authentication-box">
                            <div class="authentication-box-inner">
                                <form class="authentication-form mb-20">
                                    <div class="input-group input-group-bg mb-20">
                                        <input type="text" class="form-control" placeholder="Username / Email Address" aria-label="Username">
                                    </div>
                                    <div class="input-group input-group-bg mb-20">
                                        <input type="password" class="form-control" placeholder="Enter Password" aria-label="Username">
                                    </div>
                                    <div class="authentication-account-access mb-20">
                                        <div class="authentication-account-access-item">
                                            <div class="input-checkbox">
                                                <input type="checkbox" id="check2">
                                                <label for="check2">Remember Me!</label>
                                            </div>
                                        </div>
                                        <div class="authentication-account-access-item">
                                            <div class="authentication-link">
                                                <a href="forget-password.html">Forget password?</a>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn main-btn main-btn-secondary full-width">Login Now</button>
                                </form>
                                <div class="authentication-divider">
                                    <span>OR</span>
                                </div>
                                <ul class="social-list social-list-btn">
                                    <li class="social-btn-fb">
                                        <a href="https://www.facebook.com/" target="_blank">
                                            <i class="flaticon-facebook"></i>
                                        </a>
                                    </li>
                                    <li class="social-btn-gm">
                                        <a href="https://mail.google.com/" target="_blank">
                                            <i class="flaticon-google-plus-logo"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       




        <!-- Blog -->
        <!-- Footer -->
        <footer class="footer footer-bg">
            <div class="footer-upper pb-70 position-relative">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="footer-content-item">
                                <div class="footer-logo">
                                    <a href="#"><img src="{{asset('front/ssets/images/logo-black.png')}}" alt="logo"></a>
                                </div>
                                <ul class="footer-details footer-address">
                                    <li>
                                        <i class="flaticon-mail"></i>
                                        <a href="/cdn-cgi/l/email-protection#543c3138383b142026353d247a373b39"><span class="__cf_email__" data-cfemail="5a323f3636351a2e283b332a74393537">[email&#160;protected]</span></a>
                                    </li>
                                    <li>
                                        <i class="flaticon-telephone"></i>
                                        <a href="tel:+44-5346-338">+44 5346 338</a>
                                    </li>
                                    <li>
                                        <i class="flaticon-address"></i>
                                        3 Edgar Buildings, England, <br> BA1 2FJ.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="footer-content-list footer-content-item desk-pad-left-70">
                                <div class="footer-content-title">
                                    <h3>Quick Links</h3>
                                </div>
                                <ul class="footer-details footer-list">
                                    <li>
                                        <a href="tour.html">Popular Tour</a>
                                    </li>
                                    <li>
                                        <a href="blogs-two-column.html">Blog</a>
                                    </li>
                                    <li>
                                        <a href="products.html">Shop</a>
                                    </li>
                                    <li>
                                        <a href="faqs.html">FAQ's</a>
                                    </li>
                                    <li>
                                        <a href="privacy-policy.html">Privacy Policy</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="footer-content-list footer-content-item desk-pad-left-70">
                                <div class="footer-content-title">
                                    <h3>Important Links</h3>
                                </div>
                                <ul class="footer-details footer-list">
                                    <li>
                                        <a href="destination.html">Destination</a>
                                    </li>
                                    <li>
                                        <a href="get-in-touch.html">Get In Touch</a>
                                    </li>
                                    <li>
                                        <a href="who-we-are.html">Who We Are</a>
                                    </li>
                                    <li>
                                        <a href="contact.html">Contact Us</a>
                                    </li>
                                    <li>
                                        <a href="hotels.html">Hotels</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-3">
                            <div class="footer-content-list footer-content-item desk-pad-left-30">
                                <div class="footer-content-title">
                                    <h3>Instafeed</h3>
                                </div>
                                <div class="footer-details">
                                    <ul class="footer-gallery">
                                        <li>
                                            <a href="https://www.instagram.com/">
                                            <img src="{{asset('front/assets/images/instafeed/instafeed-1.jpg')}}" alt="insta"></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/">
                                            <img src="{{asset('front/assets/images/instafeed/instafeed-2.jpg')}}" alt="insta"></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/">
                                            <img src="{{asset('front/assets/images/instafeed/instafeed-3.jpg')}}" alt="insta"></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/">
                                            <img src="{{asset('front/assets/images/instafeed/instafeed-4.jpg')}}" alt="insta"></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/">
                                            <img src="{{asset('front/assets/images/instafeed/instafeed-5.jpg')}}" alt="insta"></a>
                                        </li>
                                        <li>
                                            <a href="https://www.instagram.com/">
                                            <img src="{{asset('front/assets/images/instafeed/instafeed-6.jpg')}}" alt="insta"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-lower">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col footer-lower-item">
                            <div class="footer-copyright-text">
                                <p>Copyright ©2021 Traip. Designed & Developed By <a href="https://envytheme.com/" target="_blank">EnvyTheme</a></p>
                            </div>
                        </div>
                        <div class="col footer-lower-item footer-lower-right">
                            Follow:
                            <ul class="social-list">
                                <li>
                                    <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                </li>
                                <li>
                                    <a href="https://www.instagram.com/" target="_blank"><i class="fab fa-instagram"></i></a>
                                </li>
                                <li>
                                    <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                                </li>
                                <li>
                                    <a href="https://linkedin.com/" target="_blank"><i class="fab fa-linkedin"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer -->

        <!-- Top Sidebar -->
        <div class="top-sidebar-wrapper">
            <div class="top-sidebar-modal">
                <div class="top-sidebar-body">
                    <div class="topbar-sidebar-header">
                        <div class="topbar-sidebar-brand">
                            <a href="#">
                                <img src="assets/images/logo-default-color.png')}}" alt="logo">
                            </a>
                        </div>
                        <div class="topbar-sidebar-close">
                            <i class="flaticon-close"></i>
                        </div>
                    </div>
                    <div class="topbar-sidebar-item">
                        <h3>Contact Us</h3>
                        <ul class="topbar-sidebar-lists">
                            <li>
                                <i class="flaticon-mail"></i>
                                <a href="/cdn-cgi/l/email-protection#0a626f6666654a7e786b637a24696567"><span class="__cf_email__" data-cfemail="58303d343437182c2a393128763b3735">[email&#160;protected]</span></a>
                            </li>
                            <li>
                                <i class="flaticon-telephone"></i>
                                <a href="tel:+44-5346-338">+44 5346 338</a>
                            </li>
                            <li>
                                <i class="flaticon-address"></i>
                                3 Edgar Buildings, England, BA1 2FJ.
                            </li>
                        </ul>
                    </div>
                    <div class="topbar-sidebar-item">
                        <h3>Follow Us</h3>
                        <ul class="social-list">
                            <li>
                                <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/" target="_blank"><i class="flaticon-instagram"></i></a>
                            </li>
                            <li>
                                <a href="https://twitter.com/" target="_blank"><i class="flaticon-twitter"></i></a>
                            </li>
                            <li>
                                <a href="https://linkedin.com/" target="_blank"><i class="flaticon-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Top Sidebar -->
        

        <!-- Search Wrapper -->
        <div class="searchbar-wrapper">
            <div class="searchbar-body">
                <div class="searchbar-close page-searchbar-close">
                    <i class="flaticon-close"></i>
                </div>
                <div class="searchbar-form">
                    <img src="assets/images/logo.png')}}" alt="logo">
                    <form>
                        <div class="form-group">
                            <input type="text" placeholder="Search*" class="form-control" required>
                            <button class="btn main-btn" type="submit">Search Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Search Wrapper -->
        
        <!-- Scroll-top -->
        <div class="scroll-top" id="scrolltop">
            <div class="scroll-top-inner">
                <i class="icofont-long-arrow-up"></i>
            </div>
        </div>
        <!-- Scroll-top -->


        <!-- essential js -->
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
        <script src="{{ asset('front/assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{ asset('front/assets/js/bootstrap.bundle.min.js')}}"></script>
        <!-- jquery ui js -->
        <script src="{{ asset('front/assets/js/jquery-ui.js')}}"></script>
        <!-- selectize js -->
        <script src="{{ asset('front/assets/js/selectize.min.js')}}"></script>
        <!-- magnific popup js -->
        <script src="{{ asset('front/assets/js/jquery.magnific-popup.min.js')}}"></script>
        <!-- owl carousel js -->
        <script src="{{ asset('front/assets/js/owl.carousel.min.js')}}"></script>
        <!-- form ajazchimp js -->
        <script src="{{ asset('front/assets/js/jquery.ajaxchimp.min.js')}}"></script>
        <!-- form validator js  -->
        <script src="{{ asset('front/assets/js/form-validator.min.js')}}"></script>
        <!-- contact form js -->
        <script src="{{ asset('front/assets/js/contact-form-script.js')}}"></script>
        <!-- meanmenu js -->
        <script src="{{ asset('front/assets/js/jquery.meanmenu.min.js')}}"></script>
        <!-- main js -->
        <script src="{{ asset('front/assets/js/script.js')}}"></script>


     

        <!-- Magnific Popup core JS file -->
        <script src="{{ asset('magnific/jquery.magnific-popup.js')}}"></script> 



        <script>
            $(document).ready(function() {
               $('.image_view2').magnificPopup({
                    type: 'image'
                    // other options
                });

            });
        </script>

         {{-- register --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
            $('#name_error').text('');
            $('#email_error').text('');
            $('#mobile_error').text('');
            $('#password_error').text('');
       
            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#register_main')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('login')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        
                        window.location.href = "{{ route('users') }}";
                            $('#position-top-start').click();
                 
                    },
                    error: function (reject) {
                        $("#add_user2").css("display", "none");
                        $("#add_user").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });
    </script>


    </body>
</html>