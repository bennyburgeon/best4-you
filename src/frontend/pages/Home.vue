<template>
  <div class="home-page">
    <!-- Slider Area -->
    <section class="slider" style="z-index:999">
      <div class="hero-slider">
        <!-- Start Single Slider -->
        <div class="single-slider" :style="{ backgroundImage: 'url(/frontend/assets/img/slider.webp)' }">
          <div class="container">
            <div class="row">
              <div class="col-lg-7">
                <div class="text">
                  <h1>
                    Best <span>Job Consultancy </span> in India<span>
                      Find Your Dream Job</span
                    >
                    with Confidence
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
        <div class="single-slider" :style="{ backgroundImage: 'url(/frontend/assets/img/slider2.webp)' }">
          <div class="container">
            <div class="row">
              <div class="col-lg-7">
                <div class="text">
                  <h1>
                    Best <span>Job Consultancy </span> in India<span>
                      Find Your Dream Job</span
                    >
                    with Confidence
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
        <div class="single-slider" :style="{ backgroundImage: 'url(/frontend/assets/img/slider3.webp)' }">
          <div class="container">
            <div class="row">
              <div class="col-lg-7">
                <div class="text">
                  <h1>
                    Best <span>Job Consultancy </span> in India<span>
                      Find Your Dream Job</span
                    >
                    with Confidence
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
      </div>
      
      <!-- Global Search Bar (Fixed over slider replacing button position) -->
      <div class="global-search-overlay w-100" style="position: absolute; top: 70%; left: 0; transform: translateY(-50%); z-index: 100; pointer-events: none;">
         <div class="container">
            <div class="row">
               <div class="col-lg-9" style="pointer-events: auto;">
                  <div class="search-container shadow-lg bg-white" style="border-radius: 50px; padding: 6px 6px 6px 20px;">
                     <form @submit.prevent="handleSearch" class="row g-0 align-items-center m-0">
                        <div class="col-md-5 border-end">
                           <div class="input-group align-items-center">
                              <i class="fa fa-search text-muted fs-5"></i>
                              <input v-model="searchQuery" type="text" class="form-control border-0 shadow-none py-3 fs-6" placeholder="Job title, skills, or company" style="background: transparent;">
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="input-group align-items-center ms-3">
                              <i class="fa fa-map-marker text-muted fs-5"></i>
                              <input v-model="searchLocation" type="text" class="form-control border-0 shadow-none py-3 fs-6" placeholder="Location (e.g. Dubai, India)" style="background: transparent;">
                           </div>
                        </div>
                        <div class="col-md-3">
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

    <!-- Start Why choose -->
    <section class="why-choose section">
      <div class="container">
        <!-- Section Title -->
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h2>Why Choose Us</h2>
              <img :src="'/frontend/assets/img/section-img.png'" alt="Section Divider" />
              <p>
                We offer expert services to help job seekers and employers
                connect with confidence and success.
              </p>
            </div>
          </div>
        </div>

        <div class="row">
          <!-- Left Content -->
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

          <!-- Right Content (Video Section) -->
          <div class="col-lg-6 col-12">
            <div class="choose-right">
              <div class="video-image">
                <!-- Video Animation -->
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

    <!-- Start services -->
    <section class="services section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h2>Our Services</h2>
              <h2>Our Recruitment & Career Services</h2>
              <img :src="'/frontend/assets/img/section-img.png'" alt="#" />
              <p>
                We provide professional recruitment and career development
                services tailored for every job seeker:
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-service">
              <i class="icofont icofont-business-man"></i>
              <h4><a href="#">Domestic Recruitment & Staffing</a></h4>
              <p>
                Connecting skilled professionals to trusted companies across
                Kerala and India.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-service">
               <i class="icofont icofont-airplane"></i>
              <h4><a href="#">Overseas Recruitment & Placement</a></h4>
              <p>
                Licensed overseas recruitment agency in India, offering genuine
                opportunities in UAE, Qatar, Saudi Arabia, Oman, and other
                Foreign countries.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-service">
            <i class="icofont icofont-ui-v-card"></i>
              <h4><a href="#">UAE Job Seeker Package</a></h4>
              <p>
                A complete package including Visa Services, CV Creation,
                Interview Assistance, Food, and Accommodation — everything you
                need to start your UAE career with confidence.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-12">
            <div class="single-service">
              <i class="icofont icofont-network"></i>
              <h4><a href="#">ATS CV Creation & Interview Training</a></h4>
              <p>
                We help you create an ATS-friendly CV and prepare for interviews
                to ensure you stand out among top candidates.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/ End services -->

    <!-- Start Feautes -->
    <section class="Feautes section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h1><strong>How We Work </strong></h1>
              <h3><b>Our Recruitment Approach</b></h3>
              <img :src="'/frontend/assets/img/section-img.png'" alt="#" />
              <p>
                Our approach is simple, transparent, and focused on results.
              </p>
              <p>
                We follow a structured process to ensure every candidate finds
                the right job match:
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-4 col-12">
            <div class="single-features">
              <div class="signle-icon">
                <i class="icofont icofont-brainstorming"></i>
              </div>
              <h3>Understanding Candidate Profile</h3>
              <p>We analyze your skills, experience, and preferences.</p>
            </div>
          </div>
          <div class="col-lg-4 col-12">
            <div class="single-features">
              <div class="signle-icon">
                <i class="icofont icofont-handshake-deal"></i>
              </div>
              <h3>Matching Opportunities</h3>
              <p>
                We connect you with verified employers in India and overseas.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-12">
            <div class="single-features last">
              <div class="signle-icon">
                <i class="icofont-file-document"></i>
              </div>
              <h3>Documentation & Visa Assistance</h3>
              <p>Complete guidance through the entire process.</p>
            </div>
          </div>
          <div class="col-lg-4 col-12">
            <div class="single-features last">
              <div class="signle-icon">
                <i class="icofont-users-alt-2"></i>
              </div>
              <h3>Interview Preparation</h3>
              <p>Personalized training to increase your selection chances.</p>
            </div>
          </div>
          <div class="col-lg-4 col-12">
            <div class="single-features last">
              <div class="signle-icon">
                <i class="icofont-rocket-alt-2"></i>
              </div>
              <h3>Deployment & Support</h3>
              <p>From offer letter to onboarding, we’re with you every step.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/ End Feautes -->

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
                <a href="#" class="btn">Contact Us</a>
                <a href="#" class="btn second"
                  >Learn More<i class="fa fa-long-arrow-right"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/ End Call to action -->

    <!-- Start portfolio -->
    <section class="portfolio section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h2>We Help You Find Your Dream Job</h2>
              <img :src="'/frontend/assets/img/section-img.png'" alt="#" />
              <p>
                Our team is dedicated to finding the right job for you, ensuring
                a perfect fit with top employers.
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12 col-12">
            <div class="owl-carousel portfolio-slider">
              <div class="single-pf">
                <img :src="'/frontend/assets/img/pf1.jpg'" alt="#" />
                <a href="#" class="btn">View Details</a>
              </div>
              <div class="single-pf">
                <img :src="'/frontend/assets/img/pf2.jpg'" alt="#" />
                <a href="#" class="btn">View Details</a>
              </div>
              <div class="single-pf">
                <img :src="'/frontend/assets/img/pf3.jpg'" alt="#" />
                <a href="#" class="btn">View Details</a>
              </div>
              <div class="single-pf">
                <img :src="'/frontend/assets/img/pf4.jpg'" alt="#" />
                <a href="#" class="btn">View Details</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--/ End portfolio -->

    <!-- Start Blog Area -->
    <section class="blog section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h2>Career Tips and Advice</h2>
              <img :src="'/frontend/assets/img/section-img.png'" alt="#" />
              <p>
                Stay updated with career-building tips and the latest job market
                trends to boost your job search.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Blog Area -->

    <!-- Start clients -->
    <div class="clients overlay">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <div class="owl-carousel clients-slider">
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ End clients -->

    <!-- Start FAQ Section -->
    <section class="faq section">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h2>FAQ</h2>
              <h3>Frequently Asked Questions</h3>
              <img :src="'/frontend/assets/img/section-img.png'" alt="Section Divider" />
              <p>Get quick answers to the most common questions from our candidates.</p>
            </div>
          </div>
        </div>

        <div class="row justify-content-center">
          <div class="col-lg-10 col-md-12">
            <div class="accordion" id="faqAccordion">
              <!-- Q1 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq1-heading">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                    Q1. How can I apply for a job?
                  </button>
                </h2>
                <div id="faq1" class="accordion-collapse collapse show" aria-labelledby="faq1-heading" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Simply upload your CV through our website or visit our office. Our recruitment team will contact you with suitable opportunities.
                  </div>
                </div>
              </div>

              <!-- Q2 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq2-heading">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                    Q2. Where is your office located?
                  </button>
                </h2>
                <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faq2-heading" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Our head office is in Dubai, UAE, with operations and support teams based in Kerala, India, to assist candidates locally and internationally.
                  </div>
                </div>
              </div>

              <!-- Q3 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq3-heading">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                    Q3. What is included in the UAE Job Seeker Package?
                  </button>
                </h2>
                <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faq3-heading" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    Our package includes food, accommodation, and interview assistance, helping candidates comfortably find their job in the UAE.
                  </div>
                </div>
              </div>

              <!-- Q4 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq4-heading">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                    Q4. Which countries do you provide job opportunities for?
                  </button>
                </h2>
                <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faq4-heading" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    We specialize in UAE and India, and we also provide recruitment services across Qatar, Oman, Bahrain, and other international destinations.
                  </div>
                </div>
              </div>

              <!-- Q5 -->
              <div class="accordion-item">
                <h2 class="accordion-header" id="faq5-heading">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                    Q5. Do you charge any registration fees?
                  </button>
                </h2>
                <div id="faq5" class="accordion-collapse collapse" aria-labelledby="faq5-heading" data-bs-parent="#faqAccordion">
                  <div class="accordion-body">
                    We offer transparent and fair recruitment processes. Charges vary based on the service or job category, and everything is clearly explained before registration.
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End FAQ Section -->

    <!-- Start Fun-facts -->
    <div id="fun-facts" class="fun-facts section overlay">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-fun">
              <i class="icofont-users-alt-5"></i>
              <div class="content">
                <span class="counter">4379</span>
                <p>Candidates Placed</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-fun">
              <i class="icofont-building-alt"></i>
              <div class="content">
                <span class="counter">850</span>
                <p>Partner Companies</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-fun">
              <i class="icofont-document-folder"></i>
              <div class="content">
                <span class="counter">6521</span>
                <p>Resumes Reviewed</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="single-fun">
              <i class="icofont-history"></i>
              <div class="content">
                <span class="counter">12</span>
                <p>Years of Service</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/ End Fun-facts -->

    <!-- Start Appointment -->
    <section class="appointment">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="section-title">
              <h2>Book Your Career Consultation</h2>
              <img :src="'/frontend/assets/img/section-img.png'" alt="#" />
              <p>
                Need personalized career guidance? Book a consultation and let
                us help you navigate your career journey.
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-12 col-12">
            <form class="form" action="#">
              <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="form-group">
                    <input name="name" type="text" placeholder="Full Name" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="form-group">
                    <input name="email" type="email" placeholder="Email Address" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="form-group">
                    <input name="phone" type="text" placeholder="Phone Number" />
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="form-group">
                    <div class="nice-select form-control wide" tabindex="0">
                      <span class="current">Job Industry</span>
                      <ul class="list">
                        <li data-value="1" class="option selected">Job Industry</li>
                        <li data-value="2" class="option">IT</li>
                        <li data-value="3" class="option">Marketing</li>
                        <li data-value="4" class="option">Healthcare</li>
                        <li data-value="5" class="option">Finance</li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                  <div class="form-group">
                    <input type="text" placeholder="Preferred Consultation Date" id="datepicker" />
                  </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12">
                  <div class="form-group">
                    <textarea name="message" placeholder="Write your message here..."></textarea>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-5 col-md-4 col-12">
                  <div class="form-group">
                    <div class="button">
                      <button type="submit" class="btn">
                        Book Consultation
                      </button>
                    </div>
                  </div>
                </div>
                <div class="col-lg-7 col-md-8 col-12">
                  <p>
                    (We will confirm your consultation via email or text
                    message)
                  </p>
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="appointment-image">
              <img :src="'/frontend/assets/img/contact-img.png'" alt="#" />
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Appointment -->

    <!-- Start Newsletter Area -->
    <section class="newsletter section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="subscribe-text">
              <h6>Sign Up for Job Alerts</h6>
              <p>
                Stay updated with the latest job openings and career advice
                directly in your inbox.
              </p>
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="subscribe-form">
              <form action="#" method="get" class="newsletter-inner">
                <input name="EMAIL" placeholder="Your email address" class="common-input" required="" type="email" />
                <button class="btn">Subscribe</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- /End Newsletter Area -->
  </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const searchQuery = ref('');
const searchLocation = ref('');

const handleSearch = () => {
    const query = {};
    if (searchQuery.value) query.q = searchQuery.value;
    if (searchLocation.value) query.location = searchLocation.value;
    router.push({ path: '/jobs', query });
};

onMounted(() => {
    const initScripts = () => {
        if (window.jQuery) {
            const $ = window.jQuery;
            
            // Re-initialize owl-carousel if defined
            if ($.fn.owlCarousel) {
                const $heroSlider = $('.hero-slider');
                if (!$heroSlider.hasClass('owl-loaded')) {
                    $heroSlider.owlCarousel({
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

                const $portfolioSlider = $('.portfolio-slider');
                if (!$portfolioSlider.hasClass('owl-loaded')) {
                    $portfolioSlider.owlCarousel({
                        autoplay: true,
                        autoplayTimeout: 4000,
                        smartSpeed: 600,
                        autoplayHoverPause: true,
                        loop: true,
                        merge: true,
                        nav: true,
                        dots: false,
                        navText: ['<i class="fa fa-angle-left" aria-hidden="true"></i>', '<i class="fa fa-angle-right" aria-hidden="true"></i>'],
                        responsive: {
                            0: { items: 1 },
                            300: { items: 2 },
                            480: { items: 2 },
                            768: { items: 3 },
                            1170: { items: 4 },
                        }
                    });
                }
            }

            // Re-initialize nice-select if defined
            if ($.fn.niceSelect) {
                $('.nice-select').niceSelect();
            }

            // Re-initialize datepicker if defined
            if ($.fn.datepicker) {
                $('#datepicker').datepicker();
            }
        }
    };

    setTimeout(initScripts, 500);
});
</script>
