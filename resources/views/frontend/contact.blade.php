@extends('layouts.frontend')

@section('title', 'Job Consultancy Contact in Kerala | Best4U Careers')
@section('meta_description', 'Find the best job consultancy in Kerala for freshers and experienced professionals. Explore the latest job opportunities and get reliable career guidance and placement support.')
@section('canonical')
<link rel="canonical" href="https://best4ucareers.com/contact" />
@endsection
@section('og_tags')
<meta property="og:url" content="https://best4ucareers.com/contact">
<meta property="og:type" content="website">
<meta property="og:title" content="Job Consultancy Contact in Kerala | Best4U Careers">
<meta property="og:description" content="Find the best job consultancy in Kerala for freshers and experienced professionals. Explore the latest job opportunities and get reliable career guidance and placement support.">
<meta property="og:image" content="{{ asset('public/frontend/assets/img/logo.jpg') }}">
<meta name="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="https://best4ucareers.com/contact">
<meta name="twitter:title" content="Job Consultancy Contact in Kerala | Best4U Careers">
<meta name="twitter:description" content="Find the best job consultancy in Kerala for freshers and experienced professionals. Explore the latest job opportunities and get reliable career guidance and placement support.">
<meta name="twitter:image" content="{{ asset('public/frontend/assets/img/logo.jpg') }}">
@endsection

@push('styles')
<style>
.breadcrumbs {
    background-image: url('{{ asset('frontend/assets/img/slider.webp') }}');
    background-size: cover;
    background-position: center;
    padding: 80px 0;
    position: relative;
    z-index: 1;
}
.breadcrumbs::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(26, 118, 209, 0.8);
    z-index: -1;
}
.breadcrumbs h1, .breadcrumbs h2 { color: #fff; font-size: 30px; font-weight: 700; text-transform: capitalize; margin-bottom: 5px; }
.bread-list li { display: inline-block; color: #fff; }
.bread-list li a { color: #fff; font-weight: 500; }
.bread-list li i { margin: 0 10px; }
</style>
@endpush

@section('content')
<div class="contact-page">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs overlay">
        <div class="container">
            <div class="bread-inner">
                <div class="row">
                    <div class="col-12">
                        <h1>Job Consultancy Contact in Kerala</h1>
                        <ul class="bread-list">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><i class="icofont-simple-right"></i></li>
                            <li class="active">Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Contact Us -->
    <section class="contact-us section">
        <div class="container">
            <div class="inner">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="contact-us-left p-4">
                            <h2 class="fw-bold mb-4">Get in touch with us</h2>
                            <p class="mb-5">We are here to help you with your career goals. Whether you're a job seeker or an employer, feel free to reach out.</p>
                            
                            <div class="single-info mb-4 d-flex">
                                <i class="icofont icofont-ui-call fs-1 text-primary me-4"></i>
                                <div class="content">
                                    <h5 class="fw-bold fs-6">Call Us Now:</h5>
                                    <p>+91 7594008787, +91 495 2921500</p>
                                </div>
                            </div>

                            <div class="single-info mb-4 d-flex">
                                <i class="icofont icofont-envelope fs-1 text-primary me-4"></i>
                                <div class="content">
                                    <h5 class="fw-bold fs-6">Email Address:</h5>
                                    <p>recruiter@best4ucareers.com</p>
                                </div>
                            </div>

                            <div class="single-info d-flex">
                                <i class="icofont icofont-google-map fs-1 text-primary me-4"></i>
                                <div class="content">
                                    <h5 class="fw-bold fs-6">Our Location:</h5>
                                    <p>1587/H, Elayambari House (Ambadi Building), Florican Road, Malaparamba, Kozhikode, Kerala 673009.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="contact-us-form p-4">
                            <h2 class="fw-bold mb-4">Send us a message</h2>
                            <form class="form" action="#" method="POST" onsubmit="alert('Message sent successfully!'); return false;">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <input type="text" name="name" placeholder="Name" class="form-control py-2" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-3">
                                            <input type="email" name="email" placeholder="Email" class="form-control py-2" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group mb-4">
                                            <textarea name="message" placeholder="Your Message" class="form-control" rows="5" required></textarea>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group login-btn">
                                            <button class="btn btn-primary w-100 py-3 fw-bold" type="submit">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.contact-us-form form').on('submit', function(e) {
        e.preventDefault();
        var $form = $(this);
        var $btn = $form.find('button[type="submit"]');
        var originalText = $btn.text();
        
        $btn.html('<span class="spinner-border spinner-border-sm me-2"></span> Sending...').prop('disabled', true);
        $form.find('.alert').remove();
        
        // Simulate AJAX request
        setTimeout(function() {
            $btn.text(originalText).prop('disabled', false);
            $form.prepend('<div class="alert alert-success border-success-subtle mb-4"><i class="fa fa-check-circle me-2"></i> Thank you for contacting us. We will get back to you soon!</div>');
            $form[0].reset();
        }, 1000);
    });
});
</script>
@endpush
