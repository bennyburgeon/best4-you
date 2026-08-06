<template>
  <div class="contact-page">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs overlay">
      <div class="container">
        <div class="bread-inner">
          <div class="row">
            <div class="col-12">
              <h2>Contact Us</h2>
              <ul class="bread-list">
                <li><router-link to="/">Home</router-link></li>
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
                <form class="form" @submit.prevent="submitContact">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group mb-3">
                        <input type="text" v-model="form.name" placeholder="Name" class="form-control py-2" required>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group mb-3">
                        <input type="email" v-model="form.email" placeholder="Email" class="form-control py-2" required>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group mb-4">
                        <textarea v-model="form.message" placeholder="Your Message" class="form-control" rows="5" required></textarea>
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
</template>

<script setup>
import { ref } from 'vue';

const form = ref({
    name: '',
    email: '',
    message: ''
});

const submitContact = () => {
    alert('Thank you for contacting us. We will get back to you soon!');
    form.value = { name: '', email: '', message: '' };
};
</script>

<style scoped>
.breadcrumbs {
    background-image: url('/frontend/assets/img/slider.webp');
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
.breadcrumbs h2 { color: #fff; font-size: 30px; font-weight: 700; text-transform: capitalize; margin-bottom: 5px; }
.bread-list li { display: inline-block; color: #fff; }
.bread-list li a { color: #fff; font-weight: 500; }
.bread-list li i { margin: 0 10px; }
</style>
