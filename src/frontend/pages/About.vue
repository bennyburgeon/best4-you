<template>
  <div class="about-page">
    <!-- Start Breadcrumb -->
    <section class="breadcrumbs" style="background-image:url('/frontend/assets/img/slider.webp')">
      <div class="container">
        <div class="row">
          <div class="container text-center">
            <h1 class="page-title">ABOUT US</h1>
          </div>
        </div>
      </div>
    </section>
    <!--/ End Breadcrumb -->

    <!-- About Section -->
    <section class="about-area section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <div class="about-img">
              <img :src="'/frontend/assets/img/about-img.jpg'" alt="About ">
            </div>
          </div>
          <div class="col-lg-6 col-md-12">
            <div class="about-content">
              <h2>MEA-Licensed Overseas Recruitment Agency in India</h2>
              <p>Best For You Workforce Planning Experts LLP, a government-licensed overseas recruitment agency in Calicut, Kerala, India, helps candidates secure overseas jobs and supports employers with reliable manpower solutions across the GCC and beyond.</p>
              <router-link to="/contact" class="btn">Apply for Overseas Jobs Now</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Detailed About -->
    <section class="why-choose section">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="choose-left">
              <h3>Who We Are</h3>
              <h2>About Best For You</h2>
              <p>At Best For You Workforce, we are more than just a job consultancy in India — we are your trusted career partner. With 7+ years of UAE recruitment experience and an overseas recruitment license approved by the Ministry of External Affairs, we help job seekers secure the right opportunities both in India and across the globe.</p>
              <p>We specialize in UAE placements and provide end-to-end recruitment support, from resume creation to interview guidance.</p>
              <p>Our mission is to empower every candidate with confidence, career clarity, and global opportunities.</p>
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

    <!-- Mission & Vision -->
    <section class="services section mission-vision-section">
      <div class="container">
        <div class="section-title white-title">
          <h2>Our Mission & Vision</h2>
          <img :src="'/frontend/assets/img/section-img.png'" alt="#">
          <p>We are driven by a mission to empower individuals and build bridges between talent and opportunity.</p>
        </div>
        <div class="row">
          <div class="col-lg-6 col-md-6 col-12">
            <div class="single-service mv-card">
              <div class="icon-circle">
                <i class="icofont icofont-rocket"></i>
              </div>
              <h4>Our Mission</h4>
              <p>Our mission is to provide high-quality, transparent, and ethical recruitment solutions that empower individuals and support organizational growth.</p>
              <p>We are committed to identifying the right talent, handling every step with accuracy, and maintaining the highest level of professionalism throughout the process.</p>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-12">
            <div class="single-service mv-card">
              <div class="icon-circle">
                <i class="icofont icofont-eye-alt"></i>
              </div>
              <h4>Our Vision</h4>
              <p>We aspire to be India’s most trusted overseas recruitment agency, recognized for our innovation, reliability, and dedication.</p>
              <p>Our vision is to create a world where opportunities meet talent — helping individuals achieve their career goals and businesses build exceptional teams.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- What We Do Section -->
    <section class="what-we-do section">
      <div class="container">
        <div class="section-title">
          <h2>What We Do</h2>
          <img :src="'/frontend/assets/img/section-img.png'" alt="#">
          <p>We specialize in providing end-to-end overseas recruitment services, covering a wide range of industries including healthcare, construction, hospitality, engineering, IT, and more.</p>
        </div>
        <div class="row">
          <div class="col-lg-3 col-md-6 col-12">
            <div class="service-card">
              <div class="icon-box"><i class="icofont-briefcase"></i></div>
              <h4>Domestic Recruitment & Staffing</h4>
              <p>Connecting Indian talent with leading companies across the nation through effective staffing solutions.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="service-card">
              <div class="icon-box"><i class="icofont-globe-alt"></i></div>
              <h4>Overseas Recruitment & Placement</h4>
              <p>Providing trusted recruitment services for clients across GCC and international markets.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="service-card">
              <div class="icon-box"><i class="icofont-airplane-alt"></i></div>
              <h4>UAE Job Seeker Package</h4>
              <p>Tailored support for candidates seeking job opportunities in the UAE — from documentation to interview prep.</p>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-12">
            <div class="service-card">
              <div class="icon-box"><i class="icofont-graduate"></i></div>
              <h4>ATS CV Creation & Interview Training</h4>
              <p>Professional resume optimization and interview coaching to help candidates stand out to employers.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="why-choose-us-section">
      <div class="container">
        <div class="section-title white-title">
          <h2>Why Choose Us</h2>
          <img :src="'/frontend/assets/img/section-img.png'" alt="#">
          <p>We don’t just fill positions — we build careers and create long-term value for organizations.</p>
        </div>
        <div class="why-list">
          <div class="why-item"><i class="icofont-check-circled"></i> Licensed by the Ministry of External Affairs, Government of India</div>
          <div class="why-item"><i class="icofont-check-circled"></i> Backed by Best For You HR Consultancy, Dubai</div>
          <div class="why-item"><i class="icofont-check-circled"></i> Dedicated team of experienced HR professionals</div>
          <div class="why-item"><i class="icofont-check-circled"></i> Transparent and ethical recruitment process</div>
          <div class="why-item"><i class="icofont-check-circled"></i> Strong global network with reputed employers</div>
        </div>
      </div>
    </section>

    <!-- Commitment -->
    <section class="commitment-modern-section">
      <div class="container">
        <div class="commitment-modern-box">
          <h2>Our Commitment</h2>
          <p>At Best For You Workforce Planning Experts LLP, we are committed to professionalism, reliability, and mutual growth.</p>
          <p>Every recruitment we handle reflects our promise of quality, transparency, and trust.</p>
        </div>
      </div>
    </section>

    <!-- Final CTA -->
    <section class="cta-section">
      <div class="container">
        <div class="cta-content">
          <h2>Ready to Start Your Career?</h2>
          <div class="cta-icons"><p>Contact us and find your dream job today.</p></div>
          <div class="cta-buttons">
            <router-link to="/contact" class="cta-btn-primary">Contact Us</router-link>
            <router-link to="/jobs" class="cta-btn-outline">Browse Jobs</router-link>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
</script>

<style scoped>
/* Breadcrumbs Overlay Background for About Page */
.breadcrumbs {
  background-size: cover;
  background-position: center;
  padding: 100px 0;
  position: relative;
  z-index: 1;
}
.breadcrumbs::after {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(26, 118, 209, 0.7);
  z-index: -1;
}
.page-title { color: #fff; font-weight: 800; font-size: 42px; }

/* Mission & Vision Section Styling */
.mission-vision-section {
  background: linear-gradient(135deg, #1a76d1 0%, #030720 100%);
  color: #fff;
  padding: 80px 0;
}
.mission-vision-section .white-title h2 { color: #fff; }

.mv-card {
  background: #fff;
  color: #333;
  border-radius: 15px;
  padding: 40px 30px;
  text-align: center;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  margin-bottom: 30px;
}
.icon-circle {
  width: 80px; height: 80px;
  background: linear-gradient(135deg, #1a76d1 0%, #030720 100%);
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px;
}
.icon-circle i { font-size: 32px; color: #fff; }

/* What We Do */
.what-we-do { background: #f8faff; padding: 80px 0; }
.service-card {
  background: #fff; border-radius: 15px; padding: 40px 25px;
  text-align: center; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
  margin-bottom: 30px; transition: 0.3s;
}
.service-card:hover { transform: translateY(-10px); }
.icon-box {
  width: 80px; height: 80px;
  background: linear-gradient(135deg, #1a76d1 0%, #030720 100%);
  border-radius: 50%; display: flex; align-items: center; justify-content: center;
  margin: 0 auto 20px; color: #fff; font-size: 32px;
}

/* Why Choose Us Section */
.why-choose-us-section {
  padding: 90px 0;
  background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('/frontend/assets/img/choose_bg.jpg') center/cover no-repeat;
  color: #fff;
}
.why-choose-us-section .white-title h2 { color: #fff; }
.why-list { max-width: 800px; margin: 40px auto 0; }
.why-item {
  display: flex; align-items: start; gap: 12px;
  background: rgba(255, 255, 255, 0.12); padding: 18px 20px;
  margin-bottom: 15px; border-radius: 12px;
  backdrop-filter: blur(4px); transition: 0.3s;
}
.why-item i { font-size: 24px; color: #8e9cae; }

/* Commitment Section */
.commitment-modern-section {
  padding: 120px 0;
  background: linear-gradient(135deg, #c2c3c4, #bcbdc7);
}
.commitment-modern-box {
  max-width: 850px; margin: 0 auto; text-align: center;
  padding: 60px 50px; background: rgba(255, 255, 255, 0.35);
  border-radius: 25px; backdrop-filter: blur(18px);
  box-shadow: 0px 20px 40px rgba(0, 0, 0, 0.12);
}

/* CTA */
.cta-section { padding: 60px 0; text-align: center; background: #fff; }
.cta-content h2 { font-size: 38px; font-weight: 800; color: #1a1c5d; margin-bottom: 15px; }
.cta-buttons { display: flex; justify-content: center; gap: 18px; margin-top: 20px; }
.cta-btn-primary { padding: 12px 30px; background: #d81f34; color: #fff; border-radius: 30px; font-weight: 600; text-decoration: none; }
.cta-btn-outline { padding: 12px 30px; border: 2px solid #5480d4; color: #1a76d1; border-radius: 30px; font-weight: 600; text-decoration: none; }
</style>
