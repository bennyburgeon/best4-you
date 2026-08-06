<template>
  <div class="upload-resume-page">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs overlay">
      <div class="container">
        <div class="bread-inner">
          <div class="row">
            <div class="col-12 text-center">
              <h2 class="text-white fw-bold fs-1">Upload Your Resume</h2>
              <ul class="bread-list list-unstyled d-flex justify-content-center gap-2 text-white">
                <li><router-link to="/" class="text-white">Home</router-link></li>
                <li><i class="icofont-simple-right"></i></li>
                <li class="active opacity-75">Upload Resume</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Upload Section -->
    <section class="upload-section py-5 bg-light">
      <div class="container">
        <div class="upload-container bg-white p-5 rounded-4 shadow-sm mx-auto" style="max-width: 700px;">
          <h2 class="text-center fw-bold mb-2">Join Our Talent Network</h2>
          <p class="text-center text-secondary mb-5">Submit your resume and let our experts help you find the perfect opportunity in India or abroad.</p>

          <!-- Alert Messages -->
          <div v-if="successMsg" class="alert alert-success border-success-subtle mb-4">
             <i class="fa fa-check-circle me-2"></i> {{ successMsg }}
          </div>
          <div v-if="errorMsg" class="alert alert-danger border-danger-subtle mb-4">
             <i class="fa fa-times-circle me-2"></i> {{ errorMsg }}
          </div>

          <!-- Upload Form -->
          <form @submit.prevent="submitResume" class="resume-form">
            <div class="row g-4">
              <!-- Name Field -->
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label fw-bold small text-uppercase text-secondary">Full Name <span class="text-danger">*</span></label>
                  <input v-model="form.name" type="text" class="form-control py-3 rounded-3" placeholder="Enter your full name" required>
                </div>
              </div>

              <!-- Email Field -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label fw-bold small text-uppercase text-secondary">Email Address <span class="text-danger">*</span></label>
                  <input v-model="form.email" type="email" class="form-control py-3 rounded-3" placeholder="email@example.com" required>
                </div>
              </div>

              <!-- Phone Field -->
              <div class="col-md-6">
                <div class="form-group">
                  <label class="form-label fw-bold small text-uppercase text-secondary">Mobile Number <span class="text-danger">*</span></label>
                  <input v-model="form.phone" type="tel" class="form-control py-3 rounded-3" placeholder="10-digit number" required>
                </div>
              </div>

              <!-- File Field -->
              <div class="col-12">
                <div class="form-group">
                  <label class="form-label fw-bold small text-uppercase text-secondary">Resume File (PDF, DOC, DOCX) <span class="text-danger">*</span></label>
                  <div class="drop-zone border-dashed p-4 rounded-3 text-center bg-light-soft position-relative">
                     <input type="file" ref="fileInput" @change="handleFileChange" class="position-absolute inset-0 opacity-0 cursor-pointer" accept=".pdf,.doc,.docx" required>
                     <div v-if="!form.file" class="py-3">
                        <i class="fa fa-cloud-upload fs-1 text-primary mb-3"></i>
                        <p class="mb-0 text-secondary">Click or drag & drop your resume here</p>
                        <small class="text-muted">Maximum file size: 5MB</small>
                     </div>
                     <div v-else class="py-3 text-success fw-bold d-flex align-items-center justify-content-center">
                        <i class="fa fa-file-text fs-4 me-2"></i> {{ form.file.name }}
                        <button type="button" @click.stop="form.file = null" class="btn btn-sm text-danger ms-3"><i class="fa fa-trash"></i></button>
                     </div>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="col-12 mt-4">
                <button type="submit" class="btn btn-primary w-100 py-3 rounded-5 fw-bold text-uppercase letter-spacing-1 shadow" :disabled="isSubmitting">
                   <span v-if="isSubmitting" class="spinner-border spinner-border-sm me-2"></span>
                   {{ isSubmitting ? 'Processing...' : 'Submit Resume' }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

const form = ref({
    name: '',
    email: '',
    phone: '',
    file: null
});

const isSubmitting = ref(false);
const successMsg = ref('');
const errorMsg = ref('');
const fileInput = ref(null);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        if (file.size > 5 * 1024 * 1024) {
            alert('File size exceeds 5MB');
            fileInput.value.value = '';
            return;
        }
        form.value.file = file;
    }
}

const submitResume = async () => {
    isSubmitting.value = true;
    successMsg.value = '';
    errorMsg.value = '';

    try {
        const formData = new FormData();
        formData.append('name', form.value.name);
        formData.append('email', form.value.email);
        formData.append('phone', form.value.phone);
        formData.append('resume', form.value.file);
        
        // Using existing application endpoint or a specific one if available
        await axios.post('/job-applications', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        successMsg.value = 'Your resume has been submitted successfully! We will contact you soon.';
        form.value = { name: '', email: '', phone: '', file: null };
        if (fileInput.value) fileInput.value.value = '';
    } catch (e) {
        errorMsg.value = e.response?.data?.message || 'Failed to submit resume. Please try again.';
    } finally {
        isSubmitting.value = false;
    }
}
</script>

<style scoped>
.breadcrumbs {
  background-image: url('/frontend/assets/img/slider.webp');
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
  background: rgba(26, 118, 209, 0.82);
  z-index: -1;
}

.border-dashed { border: 2px dashed #dee2e6; transition: 0.3s; }
.drop-zone:hover { border-color: #1a76d1; background-color: rgba(26, 118, 209, 0.05); }
.bg-light-soft { background-color: #fcfdfe; }
.cursor-pointer { cursor: pointer; }
.letter-spacing-1 { letter-spacing: 1px; }

form .form-control:focus {
    border-color: #1a76d1;
    box-shadow: 0 0 0 4px rgba(26, 118, 209, 0.1);
}
</style>
