<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Meta Tags -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Title -->
    <title>@yield('title', 'Job Portal') | Best4You</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('public/frontend/assets/img/favicon.png') }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/bootstrap.min.css') }}" />
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/nice-select.css') }}" />
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/font-awesome.min.css') }}" />
    <!-- icofont CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/icofont.css') }}" />
    <!-- Slicknav -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/slicknav.min.css') }}" />
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/owl-carousel.css') }}" />
    <!-- Datepicker CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/datepicker.css') }}" />
    <!-- Animate CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/animate.min.css') }}" />
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/magnific-popup.css') }}" />

    <!-- Medipro CSS -->
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/normalize.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/responsive.css') }}" />
    <link rel="stylesheet" href="{{ asset('public/frontend/assets/css/regions.css') }}" />

    <style>
        .navigation .nav.menu li a.active {
            color: #1a76d1;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="frontend-layout">
        <!-- Header Area -->
        <header class="header">
            <!-- Topbar -->
            <div class="topbar">
                <div class="container">
                    <div class="row align-items-center">
                        <!-- LEFT SIDE — SOCIAL MEDIA -->
                        <div class="col-lg-6 col-md-5 col-12">
                            <ul class="top-link social-icons">
                                <li><a class="facebook" href="https://www.facebook.com/bestforyouhrconsultancyIndia/"><i class="icofont-facebook"></i></a></li>
                                <li><a class="instagram" href="https://www.instagram.com/bestforyouhrconsultancy_India/"><i class="icofont-instagram"></i></a></li>
                            </ul>
                        </div>
                        <!-- RIGHT SIDE — CONTACT INFO -->
                        <div class="col-lg-6 col-md-7 col-12">
                            <ul class="top-contact">
                                <li><i class="fa fa-phone"></i>+91 7594008787</li>
                                <li><i class="fa fa-phone"></i>+91 495 2921500</li>
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:recruiter@best4ucareers.com">recruiter@best4ucareers.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ End Topbar -->

            <!-- Header Inner -->
            <div class="header-inner">
                <div class="container">
                    <div class="inner">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-12">
                                <!-- Start Logo -->
                                <div class="logo">
                                    <a href="{{ url('/') }}"><img src="{{ asset('public/frontend/assets/img/logo.jpg') }}" alt="Logo" /></a>
                                </div>
                                <!-- End Logo -->
                                <!-- Mobile Nav -->
                                <div class="mobile-nav"></div>
                                <!-- End Mobile Nav -->
                            </div>
                            <div class="col-lg-7 col-md-9 col-12">
                                <!-- Main Menu -->
                                <div class="main-menu">
                                    <nav class="navigation">
                                        <ul class="nav menu">
                                            <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">Home</a></li>
                                            <li><a href="{{ url('/about') }}" class="{{ request()->is('about') ? 'active' : '' }}">About</a></li>
                                            <li><a href="{{ url('/services') }}" class="{{ request()->is('services') ? 'active' : '' }}">Services</a></li>
                                            <li><a href="{{ url('/jobs') }}" class="{{ request()->is('jobs*') ? 'active' : '' }}">Jobs <i class="icofont-rounded-down"></i></a>
                                                <ul class="dropdown">
                                                    <li><a href="{{ url('/jobs') }}">All Jobs</a></li>
                                                    @if(isset($globalRegions))
                                                        @foreach($globalRegions as $reg)
                                                            <li><a href="{{ url('/jobs?region=' . $reg->slug) }}">Jobs in {{ $reg->name }}</a></li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </li>
                                            <li><a href="{{ url('/contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">Contact Us</a></li>
                                        </ul>
                                    </nav>
                                </div>
                                <!--/ End Main Menu -->
                            </div>
                            <div class="col-lg-2 col-12">
                                <div class="get-quote">
                                    <a href="{{ url('/upload-resume') }}" class="btn">Upload Resume</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ End Header Inner -->
        </header>
        <!-- End Header Area -->

        <!-- Main Content -->
        @if(session('success'))
            <div class="container mt-4">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        
        @yield('content')

        <!-- Footer Area -->
        <footer id="footer" class="footer">
            <!-- Footer Top -->
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer">
                                <h2>About Us</h2>
                                <p>
                                    BestForYou is a job consultancy committed to helping you find
                                    the right job. We offer personalized services to job seekers
                                    and connect them with top employers.
                                </p>
                                <ul class="social">
                                    <li><a href="https://www.facebook.com/bestforyouhrconsultancyIndia/"><i class="icofont-facebook"></i></a></li>
                                    <li><a href="https://www.instagram.com/bestforyouhrconsultancy_India/"><i class="icofont-instagram"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h2>Quick Links</h2>
                                <ul>
                                    <li><a href="{{ url('/') }}">Home</a></li>
                                    <li><a href="{{ url('/about') }}">About Us</a></li>
                                    <li><a href="{{ url('/services') }}">Services</a></li>
                                    <li><a href="{{ url('/jobs') }}">Job</a></li>
                                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h2>Job Seekers</h2>
                                <ul>
                                    <li><a href="#">Resume Building</a></li>
                                    <li><a href="#">Interview Prep</a></li>
                                    <li><a href="#">Networking</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h2>Contact Us</h2>
                                <p>1587/H, Elayambari House (Ambadi Building), Florican Road, Malaparamba, Kozhikode, Kerala 673009.</p>
                                <p>Phone: +91 7594008787, <br>+91 495 2921500</p>
                                <p>Email: recruiter@best4ucareers.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <p>&copy; 2025 BestForYou. All Rights Reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!--/ End Footer Area -->
    </div>

    <!-- jquery Min JS -->
    <script src="{{ asset('public/frontend/assets/js/jquery.min.js') }}"></script>
    <!-- jquery Migrate JS -->
    <script src="{{ asset('public/frontend/assets/js/jquery-migrate-3.0.0.js') }}"></script>
    <!-- jquery Ui JS -->
    <script src="{{ asset('public/frontend/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Easing JS -->
    <script src="{{ asset('public/frontend/assets/js/easing.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('public/frontend/assets/js/popper.min.js') }}"></script>
    <!-- Bootstrap Datepicker JS -->
    <script src="{{ asset('public/frontend/assets/js/bootstrap-datepicker.js') }}"></script>
    <!-- Jquery Nav JS -->
    <script src="{{ asset('public/frontend/assets/js/jquery.nav.js') }}"></script>
    <!-- Slicknav JS -->
    <script src="{{ asset('public/frontend/assets/js/slicknav.min.js') }}"></script>
    <!-- ScrollUp JS -->
    <script src="{{ asset('public/frontend/assets/js/jquery.scrollUp.min.js') }}"></script>
    <!-- Niceselect JS -->
    <script src="{{ asset('public/frontend/assets/js/niceselect.js') }}"></script>
    <!-- Tilt Jquery JS -->
    <script src="{{ asset('public/frontend/assets/js/tilt.jquery.min.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('public/frontend/assets/js/owl-carousel.js') }}"></script>
    <!-- counterup JS -->
    <script src="{{ asset('public/frontend/assets/js/jquery.counterup.min.js') }}"></script>
    <!-- Steller JS -->
    <script src="{{ asset('public/frontend/assets/js/steller.js') }}"></script>
    <!-- Wow JS -->
    <script src="{{ asset('public/frontend/assets/js/wow.min.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('public/frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('public/frontend/assets/js/bootstrap.min.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('public/frontend/assets/js/main.js') }}"></script>
    
    @stack('scripts')
</body>
</html>
