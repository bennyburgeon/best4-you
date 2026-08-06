<template>
  <div class="services-page">
    <!-- Start Breadcrumb -->
    <section class="breadcrumbs" style="background-image:url('/frontend/assets/img/slider.webp')">
      <div class="container text-center">
        <h1 class="page-title text-white">OUR SERVICES</h1>
        <p class="text-white fs-5 opacity-90">Premium Recruitment & Workforce Solutions for India and Abroad</p>
      </div>
    </section>

    <!-- Domestic Recruitment Section -->
    <section class="service-modern">
      <div class="container service-flex">
        <div class="service-text">
          <h2>Domestic Recruitment & Staffing</h2>
          <h4>Building Strong Teams for India’s Leading Businesses</h4>
          <p>We specialize in domestic recruitment and staffing solutions that help organizations across Kerala and India find the right talent quickly and efficiently. Our process focuses on understanding your business goals and identifying candidates who align with your culture, skills, and long-term objectives.</p>
          <h5>We Recruit For:</h5>
          <ul class="service-list">
            <li>IT & Technology</li>
            <li>Construction & Engineering</li>
            <li>Retail & Sales</li>
            <li>Healthcare</li>
            <li>Administration & Operations</li>
          </ul>
          <router-link to="/contact" class="service-btn">Hire the Right Talent Today</router-link>
        </div>
        <div class="service-img">
          <img :src="'/frontend/assets/img/services/domestic_recruitement.jpg'" alt="Domestic Recruitment">
        </div>
      </div>
    </section>

    <!-- Overseas Recruitment Section -->
    <section class="service-modern alt-bg">
      <div class="container service-flex">
        <div class="service-img">
          <img :src="'/frontend/assets/img/services/overseas_recruitement.jpg'" alt="Overseas Recruitment">
        </div>
        <div class="service-text">
          <h2>Overseas Recruitment & Placement</h2>
          <h4>Licensed Overseas Recruitment for Global Employers</h4>
          <p>As an MEA-licensed overseas recruitment agency based in Calicut, Kerala, India, we connect skilled Indian professionals with top employers across the GCC, UAE, and other international markets. Our overseas recruitment process covers every step — from candidate sourcing to visa documentation — ensuring full compliance and transparency.</p>
          <h5>Our Overseas Services Include:</h5>
          <ul class="service-list">
            <li>Candidate Sourcing & Pre-Screening</li>
            <li>Interview Coordination</li>
            <li>Visa & Documentation Assistance</li>
            <li>Deployment & Post-Placement Support</li>
          </ul>
          <router-link to="/contact" class="service-btn">Apply for Overseas Jobs Now</router-link>
        </div>
      </div>
    </section>

    <!-- UAE Job Package Section -->
    <section class="uae-job-package" style="background-image: url('/frontend/assets/img/services/section3.jpg')">
      <div class="container py-5">
        <div class="text-center mb-5 bg-white-glass p-5 rounded-4 border">
          <h2 class="section-title-premium text-gold mb-3">UAE Job Seeker Package</h2>
          <h3 class="section-headline mb-4 fs-2">Your All-in-One Support for Job Hunting in the UAE</h3>
          <p class="section-desc mb-0">Our UAE Job Seeker Package is designed for professionals planning to explore career opportunities in the United Arab Emirates. From resume creation to interview preparation and job application guidance, we help you stand out in the competitive UAE job market.</p>
        </div>

        <div class="package-grid py-4">
          <div class="package-card glass-morphism">
            <h4>What’s Included:</h4>
            <div class="row">
               <div class="col-md-6">
                  <ul class="service-list">
                    <li>60 Days Dubai Visit Visa</li>
                    <li>Free Registration</li>
                    <li>Placement Assistance</li>
                    <li>Bachelor’s Accommodation</li>
                    <li>30 Days Meal Support</li>
                  </ul>
               </div>
               <div class="col-md-6">
                  <ul class="service-list">
                    <li>Airport Pickup Service</li>
                    <li>Metro Card</li>
                    <li>Professional CV Creation</li>
                    <li>Interview & Coaching</li>
                    <li>And much more...</li>
                  </ul>
               </div>
            </div>
          </div>
          <div class="uae-visual-box rounded-4 overflow-hidden position-relative border border-2 border-white">
            <div class="uae-overlay"></div>
            <div class="uae-text-center position-relative z-1 p-5 text-center text-white h-100 d-flex flex-column justify-content-center align-items-center">
              <h3 class="text-gold fs-1 fw-bold mb-3">Your UAE Journey Starts Here</h3>
              <p class="fs-5 mb-4">Get complete support from arrival to placement — designed for serious job seekers.</p>
              <router-link to="/contact" class="cta-btn-gold">Start Your Journey Today</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- ATS CV Creation Section -->
    <section class="ats-section">
      <div class="container py-5">
        <div class="row align-items-center">
          <div class="col-lg-7">
            <div class="text-block">
              <h2 class="ats-title mb-3">ATS CV Creation & Interview Training</h2>
              <h3 class="ats-headline text-white mb-4">Stand Out with a Professional ATS-Friendly CV</h3>
              <p class="ats-desc mb-5 op-90 fs-5">In today’s competitive job market, your resume must pass Applicant Tracking Systems (ATS) while impressing recruiters instantly. Our experts build modern, keyword-optimized CVs that match international standards, along with interview training that boosts your confidence and performance.</p>
              <h4 class="sub-title text-gold mb-3 fw-bold">Our Training Covers:</h4>
              <ul class="ats-list list-unstyled row">
                <li class="col-md-6 text-white mb-2"><i class="fa fa-check-circle text-gold me-2"></i> ATS Resume Writing</li>
                <li class="col-md-6 text-white mb-2"><i class="fa fa-check-circle text-gold me-2"></i> Mock Interviews</li>
                <li class="col-md-6 text-white mb-2"><i class="fa fa-check-circle text-gold me-2"></i> Personality Coaching</li>
                <li class="col-md-6 text-white mb-2"><i class="fa fa-check-circle text-gold me-2"></i> Experience Support</li>
              </ul>
              <div class="mt-5">
                 <router-link to="/contact" class="ats-btn">Get Your Professional CV Now</router-link>
              </div>
            </div>
          </div>
          <div class="col-lg-5 mt-5 mt-lg-0">
             <div class="ats-image-box shadow-lg rounded-4 overflow-hidden border">
                <img :src="'/frontend/assets/img/services/section4.jpg'" alt="CV Services" class="img-fluid">
             </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta-section py-5">
       <div class="container py-4">
          <div class="final-cta-box glass-dark p-5 rounded-4 text-center">
              <h2 class="final-title text-gold fs-1 fw-bold mb-3">Your Trusted Recruitment Partner</h2>
              <p class="final-desc fs-4 mb-4 opacity-75">Connect with us and land your dream career.</p>
              <router-link to="/contact" class="final-btn px-5 py-3 fs-5 fw-bold">Connect Now</router-link>
          </div>
       </div>
    </section>
  </div>
</template>

<script setup>
</script>

<style scoped>
.breadcrumbs {
  background-size: cover;
  background-position: center;
  padding: 120px 0 80px;
  position: relative;
  z-index: 1;
}
.breadcrumbs::before {
  content: "";
  position: absolute;
  inset: 0;
  background: rgba(26, 118, 209, 0.85);
  z-index: -1;
}
.page-title { font-size: 50px; font-weight: 800; }

/* Service Modern General */
.service-modern { padding: 90px 0; }
.service-flex { display: flex; align-items: center; gap: 60px; }
.service-text { width: 55%; }
.service-img { width: 45%; }
.service-img img { width: 100%; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); }
.service-text h2 { font-size: 40px; font-weight: 800; color: #1f4079; margin-bottom: 15px; }
.service-text h4 { font-size: 22px; font-weight: 600; color: #333; margin-bottom: 25px; }
.service-text p { line-height: 1.8; font-size: 17px; color: #555; }
.service-list { list-style: none; padding: 0; font-size: 16px; margin: 25px 0; }
.service-list li { margin-bottom: 12px; font-weight: 500; display: flex; align-items: center; }
.service-list li::before { content: "✔"; color: #00c6ba; font-weight: bold; margin-right: 12px; font-size: 18px; }
.service-btn { display: inline-block; padding: 14px 35px; background: #1f4079; color: #fff; font-weight: 700; border-radius: 50px; text-decoration: none; transition: 0.3s; margin-top: 20px; }
.service-btn:hover { background: #1a76d1; transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
.alt-bg { background: #f4f8ff; }

/* UAE Package Section */
.uae-job-package { background-size: cover; background-position: center; background-attachment: fixed; }
.bg-white-glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
.text-gold { color: #c69b36; }
.section-title-premium { font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
.package-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
.glass-morphism { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(5px); border: 1px solid #e1d6b8; padding: 40px; border-radius: 20px; }
.uae-visual-box { min-height: 400px; background: url('/frontend/assets/img/slider2.webp') center/cover; }
.uae-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.5); }
.cta-btn-gold { display: inline-block; background: linear-gradient(135deg, #c69b36, #e8c46a); padding: 16px 40px; border-radius: 50px; color: #000; font-weight: 800; text-transform: uppercase; text-decoration: none; box-shadow: 0 10px 20px rgba(0,0,0,0.2); transition: 0.3s; }
.cta-btn-gold:hover { transform: scale(1.05); }

/* ATS CV Section */
.ats-section { background: linear-gradient(135deg, #0a3d62, #3c6382); }
.ats-title { color: #f8d58c; font-weight: 800; font-size: 38px; }
.sub-title { color: #f8d58c; }
.ats-btn { background: #f8d58c; color: #000; padding: 16px 40px; border-radius: 50px; text-decoration: none; font-weight: 700; font-size: 18px; transition: 0.3s; display: inline-block; }
.ats-btn:hover { background: #fff1c7; transform: translateY(-5px); }

/* Finals */
.glass-dark { background: rgba(0,0,0,0.7); backdrop-filter: blur(15px); border: 1px solid rgba(255,255,255,0.1); }
.final-btn { background: #f5d283; color: #000; border-radius: 50px; text-decoration: none; transition: 0.3s; }
.final-btn:hover { background: #fff; transform: scale(1.1); }

/* Mobile */
@media (max-width: 992px) {
  .service-flex, .package-grid { flex-direction: column; grid-template-columns: 1fr; text-align: center; }
  .service-text, .service-img { width: 100%; }
  .service-list li { justify-content: center; }
}
</style>
