@extends('layouts.frontend')
@section('title', 'Best Job Consultancy in India | Best4U Careers')
@section('meta_description', 'Find the best job consultancy in Kerala for freshers and experienced professionals. Explore the latest job opportunities and get reliable career guidance and placement support.')
@section('canonical')
<link rel="canonical" href="https://best4ucareers.com/" />
@endsection

@section('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EmploymentAgency",
  "name": "Best4U Careers",
  "url": "https://best4ucareers.com/",
  "telephone": "+91 7594008787",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "1587/H, Elayambari House (Ambadi Building), Florican Road, Malaparamba, Kozhikode, Kerala",
    "addressLocality": "Kozhikode",
    "postalCode": "673009",
    "addressCountry": "IN"
  },
  "geo": {
    "@type": "GeoCoordinates",
    "latitude": 11.2923445,
    "longitude": 75.79813860000002
  },
  "openingHoursSpecification": {
    "@type": "OpeningHoursSpecification",
    "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    "opens": "09:00",
    "closes": "06:00"
  },
  "sameAs": [
    "https://www.facebook.com/bestforyouhrconsultancyIndia/",
    "https://www.instagram.com/bestforyouhrconsultancy_India/"
  ]
}
</script>
@endsection

@push('styles')
<style>
/* Desktop Search Bar & Slider Enhancements */
.slider {
  position: relative !important;
}

.slider .single-slider {
  height: 700px !important;
}

.global-search-overlay {
  position: absolute;
  left: 0;
  z-index: 100;
  pointer-events: none;
  top: auto !important;
  bottom: 210px !important;
  transform: none !important;
}

.search-container {
  border-radius: 50px;
  padding: 6px 6px 6px 20px;
  background: #fff;
  transition: all 0.3s ease;
  box-shadow: 0 15px 45px rgba(31, 64, 121, 0.12) !important;
}

/* Mobile/Tablet Responsive Styles */
@media (max-width: 991px) {
  .slider .single-slider {
    height: 380px !important; /* Keep mobile height */
  }

  .global-search-overlay {
    position: relative !important;
    top: 0 !important;
    bottom: auto !important;
    transform: none !important;
    margin-top: -40px !important;
    margin-bottom: 30px !important;
    z-index: 110 !important;
    pointer-events: auto !important;
  }
  
  .slider {
    padding-bottom: 10px !important;
  }

  .search-container {
    border-radius: 20px !important;
    padding: 18px 20px !important;
  }

  .search-container .col-lg-5,
  .search-container .col-lg-4 {
    border-bottom: 1px solid #e2e8f0;
    border-right: 0 !important;
    padding-bottom: 10px;
    margin-bottom: 10px;
  }

  .search-container .ms-3,
  .search-container .ml-3 {
    margin-left: 0 !important;
  }

  .search-container .col-lg-3 {
    margin-top: 12px;
  }
  
  .search-container .input-group i {
    font-size: 16px;
    margin-right: 10px;
  }
}
.regions-section .card:hover {
  transform: translateY(-8px);
}
</style>
@endpush

@section('content')
<div class="home-page">
    <!-- Slider Area -->
    <section class="slider">
        <div class="hero-slider">
            <!-- Start Single Slider -->
            <div class="single-slider" style="background-image: url('{{ asset('public/frontend/assets/img/slider.webp') }}')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h1>
                                    Best <span>Job Consultancy </span> in India<br>
                                    <span>Find Your Dream Job</span> with Confidence
                                </h1>
                                <p>
                                    We connect skilled job seekers with trusted employers in
                                    India and abroad — helping you build a successful career.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Slider -->

            <!-- Start Single Slider -->
            <div class="single-slider" style="background-image: url('{{ asset('public/frontend/assets/img/slider2.webp') }}')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h2>
                                    Best <span>Job Consultancy </span> in India<br>
                                    <span>Find Your Dream Job</span> with Confidence
                                </h2>
                                <p>
                                    We connect skilled job seekers with trusted employers in
                                    India and abroad — helping you build a successful career.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Slider -->

            <!-- Start Single Slider -->
            <div class="single-slider" style="background-image: url('{{ asset('public/frontend/assets/img/slider3.webp') }}')">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="text">
                                <h2>
                                    Best <span>Job Consultancy </span> in India<br>
                                    <span>Find Your Dream Job</span> with Confidence
                                </h2>
                                <p>
                                    We connect skilled job seekers with trusted employers in
                                    India and abroad — helping you build a successful career.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Single Slider -->
        </div>
        
        <!-- Global Search Bar -->
        <div class="global-search-overlay w-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" style="pointer-events: auto;">
                        <div class="search-container shadow-lg bg-white">
                            <form action="{{ url('/jobs') }}" method="GET" class="row g-0 align-items-center m-0">
                                <div class="col-lg-5 border-end">
                                    <div class="input-group align-items-center">
                                        <i class="fa fa-search text-muted fs-5"></i>
                                        <input name="search" type="text" class="form-control border-0 shadow-none py-3 fs-6" placeholder="Job title, skills, or company" style="background: transparent;">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="input-group align-items-center ms-3">
                                        <i class="fa fa-map-marker text-muted fs-5"></i>
                                        <input name="location" type="text" class="form-control border-0 shadow-none py-3 fs-6" placeholder="Location (e.g. Dubai, India)" style="background: transparent;">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 40px; padding: 14px 0; font-size: 16px;">Search Jobs</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Slider Area -->

    <!-- Start Schedule Area -->
    <section class="schedule">
        <div class="container">
            <div class="schedule-inner">
                <div class="row">
                    <!-- Resume Help -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-schedule first">
                            <div class="inner">
                                <div class="icon">
                                    <i class="fa fa-file-text"></i>
                                </div>
                                <div class="single-content">
                                    <span>Career Assistance</span>
                                    <h4>Resume & Profile Building</h4>
                                    <p>
                                        We help job seekers create professional resumes and
                                        optimize LinkedIn profiles to stand out in competitive
                                        markets.
                                    </p>
                                    <a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Career Counseling -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="single-schedule middle">
                            <div class="inner">
                                <div class="icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="single-content">
                                    <span>Expert Guidance</span>
                                    <h4>Career Counseling</h4>
                                    <p>
                                        Get one-on-one sessions with our career experts to explore
                                        job options and define a successful career path.
                                    </p>
                                    <a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Hours -->
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="single-schedule last">
                            <div class="inner">
                                <div class="icon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="single-content">
                                    <span>Visit Us</span>
                                    <h4>Working Hours</h4>
                                    <ul class="time-sidual">
                                        <li class="day">
                                            Monday - Friday <span>9:00 AM - 6:00 PM</span>
                                        </li>
                                        <li class="day">
                                            Saturday <span>10:00 AM - 4:00 PM</span>
                                        </li>
                                        <li class="day">Sunday <span>Closed</span></li>
                                    </ul>
                                    <a href="#">LEARN MORE<i class="fa fa-long-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/End Start schedule Area -->

    <!-- Start Regions Section -->
    <section class="regions-section section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Explore Opportunities by Region</h2>
                        <img src="{{ asset('public/frontend/assets/img/section-img.png') }}" alt="Section Divider" />
                        <p>Discover your next career move across top global destinations.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if(isset($globalRegions))
                    @foreach($globalRegions as $reg)
                        @php
                            $color = '#6b7280';
                            $icon = 'icofont-globe';
                            if ($reg->slug === 'india') { $color = '#1a76d1'; $icon = 'icofont-location-pin'; }
                            else if ($reg->slug === 'gulf') { $color = '#f59e0b'; $icon = 'icofont-location-pin'; }
                            else if ($reg->slug === 'europe') { $color = '#10b981'; $icon = 'icofont-location-pin'; }
                        @endphp
                        <div class="col-lg-3 col-md-6 col-12 mb-4">
                            <div class="card border-0 shadow-sm text-center h-100 p-4 regions-card">
                                <div class="icon mb-3 regions-icon" style="color: #6b7280;"><i class="icofont-globe"></i></div>
                                <h4 class="fw-bold mb-2">Jobs in {{ $reg->name }}</h4>
                                <p class="text-muted mb-3">Explore opportunities and build your career in {{ $reg->name }}.</p>
                                <a href="{{ url('/jobs?region=' . $reg->slug) }}" class="btn btn-outline-primary btn-sm mt-auto regions-btn">Browse Jobs</a>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>
    <!--/ End Regions Section -->

    <!-- Start Why choose -->
    <section class="why-choose section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Why Choose Us</h2>
                        <img src="{{ asset('public/frontend/assets/img/section-img.png') }}" alt="Section Divider" />
                        <p>
                            We offer expert services to help job seekers and employers
                            connect with confidence and success.
                        </p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="choose-left">
                        <h3>Who We Are</h3>
                        <h2>About Best For You</h2>
                        <p>
                            At Best For You Workforce, we are more than just a job
                            consultancy in India — we are your trusted career partner. With
                            7+ years of UAE recruitment experience and an overseas
                            recruitment license approved by the Ministry of External
                            Affairs, we help job seekers secure the right opportunities both
                            in India and across the globe.
                        </p>
                        <p>
                            We specialize in UAE placements and provide end-to-end
                            recruitment support, from resume creation to interview guidance.
                        </p>
                        <p>
                            Our mission is to empower every candidate with confidence,
                            career clarity, and global opportunities.
                        </p>
                    </div>
                </div>

                <div class="col-lg-6 col-12">
                    <div class="choose-right">
                        <div class="video-image">
                            <div class="promo-video">
                                <div class="waves-block">
                                    <div class="waves wave-1"></div>
                                    <div class="waves wave-2"></div>
                                    <div class="waves wave-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Why choose -->

    <!-- Start Call to action -->
    <section class="call-action overlay" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="content">
                        <h2>Looking for Your Next Job? Call Us at +91 495 2921500</h2>
                        <p>
                            Find your dream job with our expert job consultancy services. We
                            help you land the career you deserve!
                        </p>
                        <div class="button">
                            <a href="{{ url('/contact') }}" class="btn">Contact Us</a>
                            <a href="{{ url('/about') }}" class="btn second">Learn More<i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Call to action -->
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.owlCarousel) {
            $('.hero-slider').owlCarousel({
                loop: true,
                autoplay: true,
                smartSpeed: 500,
                autoplayTimeout: 5000,
                items: 1,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
                dots: true,
                animateOut: 'fadeOut',
                autoplayHoverPause: true,
            });
        }
    });
</script>
@endpush
