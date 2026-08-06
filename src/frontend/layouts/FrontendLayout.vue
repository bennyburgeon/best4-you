<template>
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
                  <router-link to="/"><img :src="'/frontend/assets/img/logo.jpg'" alt="#"  /></router-link>
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
                      <li><router-link to="/" active-class="active">Home</router-link></li>
                      <li><router-link to="/about" active-class="active">About</router-link></li>
                      <li><router-link to="/services" active-class="active">Services</router-link></li>
                      <li><router-link to="/jobs" active-class="active">Jobs</router-link></li>
                      <li><router-link to="/contact" active-class="active">Contact Us</router-link></li>
                    </ul>
                  </nav>
                </div>
                <!--/ End Main Menu -->
              </div>
              <div class="col-lg-2 col-12">
                <div class="get-quote">
                  <router-link to="/upload-resume" class="btn">Upload Resume</router-link>
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
    <router-view></router-view>

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
                  <li><router-link to="/">Home</router-link></li>
                  <li><router-link to="/about">About Us</router-link></li>
                  <li><router-link to="/services">Services</router-link></li>
                  <li><router-link to="/jobs">Job</router-link></li>
                  <li><router-link to="/contact">Contact</router-link></li>
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
</template>

<script setup>
import { onMounted } from 'vue';

onMounted(() => {
    // Re-initialize main.js from template if needed
    if (window.initMain) window.initMain();
});
</script>

<style scoped>
.navigation .nav.menu li a.active {
    color: #1a76d1;
}
</style>
