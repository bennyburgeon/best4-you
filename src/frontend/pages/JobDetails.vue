<template>
  <div class="job-details-page" v-if="job">
    <section class="detail-hero">
      <div class="container">
        <div class="breadcrumb-row">
          <router-link to="/">Home</router-link>
          <i class="fa fa-angle-right"></i>
          <router-link to="/jobs">Jobs</router-link>
          <i class="fa fa-angle-right"></i>
          <span>{{ job.title }}</span>
        </div>

        <div class="hero-card">
          <div class="role-mark">{{ initials(job.title) }}</div>
          <div class="role-intro">
            <div class="meta-row">
              <span v-if="job.job_code" class="code-pill"><i class="fa fa-hashtag"></i>{{ job.job_code }}</span>
              <span class="category-pill">{{ job.category?.name || 'General' }}</span>
              <span v-if="job.job_type" class="type-pill"><i class="fa fa-star"></i>{{ job.job_type?.name }}</span>
            </div>
            <h1>{{ job.title }}</h1>
            <div class="hero-facts">
              <span><i class="fa fa-map-marker"></i>{{ job.location || 'Remote' }}</span>
              <span><i class="fa fa-clock-o"></i>Posted {{ timeAgo(job.created_at) }}</span>
              <span><i class="fa fa-briefcase"></i>{{ experienceLabel(job) }}</span>
            </div>
          </div>
          <button class="hero-apply" @click="showModal = true">
            Apply Now
            <i class="fa fa-arrow-right"></i>
          </button>
        </div>
      </div>
    </section>

    <section class="detail-content">
      <div class="container">
        <div class="row g-4 align-items-start">
          <div class="col-lg-8">
            <article class="content-card">
              <div class="section-heading">
                <span>Role Description</span>
                <h2>Responsibilities and expectations</h2>
              </div>
              <div class="job-description" v-html="job.roles_and_responsibility"></div>
            </article>

            <article v-if="job.skills?.length" class="content-card skills-card">
              <div class="section-heading">
                <span>Required Skills</span>
                <h2>What helps you succeed</h2>
              </div>
              <div class="skill-cloud">
                <span v-for="skill in job.skills" :key="skill.id">{{ skill.name }}</span>
              </div>
            </article>
          </div>

          <aside class="col-lg-4">
            <div class="overview-card">
              <div class="overview-header">
                <h2>Job Overview</h2>
                <span>Quick details</span>
              </div>

              <ul class="overview-list">
                <li>
                  <i class="fa fa-money"></i>
                  <div>
                    <span>Salary Range</span>
                    <strong>{{ salaryLabel(job) }}</strong>
                  </div>
                </li>
                <li>
                  <i class="fa fa-briefcase"></i>
                  <div>
                    <span>Job Category</span>
                    <strong>{{ job.category?.name || 'General' }}</strong>
                  </div>
                </li>
                <li v-if="job.job_type">
                  <i class="fa fa-star"></i>
                  <div>
                    <span>Employment Type</span>
                    <strong>{{ job.job_type.name }}</strong>
                  </div>
                </li>
                <li>
                  <i class="fa fa-calendar"></i>
                  <div>
                    <span>Closing Date</span>
                    <strong>{{ closingDateLabel }}</strong>
                  </div>
                </li>
                <li>
                  <i class="fa fa-map-marker"></i>
                  <div>
                    <span>Location</span>
                    <strong>{{ job.location || 'Remote' }}</strong>
                  </div>
                </li>
              </ul>

              <button class="apply-button" @click="showModal = true">Apply for this role</button>
              <p class="privacy-note"><i class="fa fa-lock"></i>Your application is confidential</p>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <div v-if="showModal" class="apply-modal">
      <div class="modal-shell">
        <div class="modal-header">
          <div>
            <span>Application</span>
            <h3>Apply for {{ job.title }}</h3>
          </div>
          <button type="button" @click="showModal = false" aria-label="Close application form">
            <i class="fa fa-times"></i>
          </button>
        </div>

        <div v-if="successMsg" class="success-box">{{ successMsg }}</div>

        <form v-else class="application-form" @submit.prevent="submitApplication">
          <label>
            <span>Full Name</span>
            <input v-model="form.name" type="text" required>
          </label>
          <label>
            <span>Email Address</span>
            <input v-model="form.email" type="email" required>
          </label>
          <label>
            <span>Phone Number</span>
            <input v-model="form.phone" type="tel" required>
          </label>
          <label>
            <span>Upload Resume</span>
            <input ref="fileInput" type="file" accept=".pdf,.doc,.docx" @change="handleFileChange">
          </label>

          <div class="form-actions">
            <button type="button" class="cancel-button" @click="showModal = false">Cancel</button>
            <button type="submit" class="submit-button" :disabled="isSubmitting">
              {{ isSubmitting ? 'Submitting...' : 'Submit Application' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div v-else-if="loading" class="page-loader">
    <div class="spinner-border text-primary" role="status"></div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const job = ref(null);
const loading = ref(true);
const showModal = ref(false);
const isSubmitting = ref(false);
const successMsg = ref('');
const fileInput = ref(null);

const form = ref({
  name: '',
  email: '',
  phone: '',
  file: null,
});

const closingDateLabel = computed(() => {
  if (!job.value?.closing_date) return 'Ongoing';
  return new Date(job.value.closing_date).toLocaleDateString();
});

const fetchJob = async () => {
  loading.value = true;
  try {
    const res = await axios.get(`/jobs/${route.params.id}`);
    job.value = res.data;
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};

const handleFileChange = (e) => {
  const file = e.target.files[0];
  if (!file) return;

  if (file.size > 10 * 1024 * 1024) {
    alert('File size exceeds 10MB');
    fileInput.value.value = '';
    return;
  }

  form.value.file = file;
};

const submitApplication = async () => {
  isSubmitting.value = true;
  try {
    const formData = new FormData();
    formData.append('job_id', job.value.id);
    formData.append('name', form.value.name);
    formData.append('email', form.value.email);
    formData.append('phone', form.value.phone);
    if (form.value.file) formData.append('resume', form.value.file);

    await axios.post('/job-applications', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });

    successMsg.value = 'Application submitted successfully!';
    setTimeout(() => {
      showModal.value = false;
      successMsg.value = '';
      form.value = { name: '', email: '', phone: '', file: null };
      if (fileInput.value) fileInput.value.value = '';
    }, 3000);
  } catch (e) {
    alert('Error submitting application.');
  } finally {
    isSubmitting.value = false;
  }
};

const timeAgo = (date) => {
  const seconds = Math.floor((new Date() - new Date(date)) / 1000);
  const days = seconds / 86400;
  if (days > 1) return `${Math.floor(days)} days ago`;
  return 'Recently';
};

const experienceLabel = (role) => {
  if (role.experience_min !== null && role.experience_min !== undefined) {
    return `${role.experience_min}-${role.experience_max} Yrs`;
  }
  return 'Any experience';
};

const salaryLabel = (role) => {
  if (role.salary_from && role.salary_to && role.currency) {
    return `${role.currency.symbol}${role.salary_from} - ${role.currency.symbol}${role.salary_to}`;
  }
  return role.salary || 'Negotiable';
};

const initials = (title = '') => {
  return title
    .split(' ')
    .filter(Boolean)
    .slice(0, 2)
    .map(word => word[0])
    .join('')
    .toUpperCase() || 'B4';
};

onMounted(fetchJob);
</script>

<style scoped>
.job-details-page {
  background: #f4f7fb;
  color: #2C2D3F;
  font-size: 14px;
  min-height: 100vh;
}

.detail-hero {
  background:
    linear-gradient(135deg, rgba(31, 64, 121, 0.92), rgba(44, 45, 63, 0.74)),
    url('/frontend/assets/img/slider3.webp') center/cover;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
  color: #fff;
  padding: 55px 0 95px;
}

.breadcrumb-row {
  align-items: center;
  color: rgba(255, 255, 255, 0.78);
  display: flex;
  flex-wrap: wrap;
  font-size: 14px;
  font-weight: 400;
  gap: 10px;
  margin-bottom: 25px;
}

.breadcrumb-row a {
  color: #fff;
  text-decoration: none;
}

.hero-card {
  align-items: center;
  background: rgba(255, 255, 255, 0.14);
  border: 1px solid rgba(255, 255, 255, 0.24);
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
  display: grid;
  gap: 20px;
  grid-template-columns: auto 1fr auto;
  padding: 24px;
}

.role-mark {
  align-items: center;
  background: #fff;
  border-radius: 15px;
  color: #1f4079;
  display: flex;
  font-size: 20px;
  font-weight: 600;
  height: 70px;
  justify-content: center;
  width: 70px;
}

.meta-row {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 12px;
}

.category-pill,
.code-pill,
.type-pill {
  border-radius: 999px;
  display: inline-flex;
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 0;
  padding: 6px 12px;
  text-transform: uppercase;
}

.category-pill {
  background: rgba(255, 255, 255, 0.18);
  color: #fff;
}

.code-pill {
  background: #fff;
  color: #1f4079;
}

.type-pill {
  background: #e11d48;
  color: #fff;
}

.role-intro h1 {
  font-size: 38px;
  font-weight: 700;
  letter-spacing: 0;
  line-height: 42px;
  margin-bottom: 14px;
}

.hero-facts {
  display: flex;
  flex-wrap: wrap;
  gap: 12px 24px;
}

.hero-facts span {
  color: rgba(255, 255, 255, 0.84);
  font-size: 14px;
  font-weight: 400;
}

.hero-facts i {
  color: #fff;
  margin-right: 8px;
}

.hero-apply,
.apply-button,
.submit-button {
  align-items: center;
  background: #1f4079;
  border: 0;
  border-radius: 40px;
  color: #fff;
  display: inline-flex;
  font-size: 14px;
  font-weight: 500;
  gap: 10px;
  justify-content: center;
  min-height: 46px;
  padding: 13px 25px;
  transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.hero-apply {
  background: #fff;
  color: #1f4079;
  white-space: nowrap;
}

.hero-apply:hover,
.apply-button:hover,
.submit-button:hover {
  box-shadow: 0 10px 22px rgba(31, 64, 121, 0.2);
  transform: translateY(-2px);
}

.detail-content {
  margin-top: -62px;
  padding-bottom: 70px;
  position: relative;
}

.content-card,
.overview-card {
  background: #fff;
  border: 1px solid #e6edf5;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(32, 48, 73, 0.08);
}

.content-card {
  margin-bottom: 20px;
  padding: 28px;
}

.section-heading span,
.overview-header span,
.modal-header span {
  color: #1f4079;
  display: inline-block;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0;
  margin-bottom: 8px;
  text-transform: uppercase;
}

.section-heading h2,
.overview-header h2 {
  font-size: 24px;
  font-weight: 600;
  margin-bottom: 20px;
}

.job-description {
  color: #526173;
  font-size: 14px;
  line-height: 24px;
}

.job-description :deep(ul),
.job-description :deep(ol) {
  padding-left: 1.2rem;
}

.job-description :deep(li) {
  margin-bottom: 8px;
}

.skill-cloud {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.skill-cloud span {
  background: #eef2fa;
  border-radius: 999px;
  color: #1f4079;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 13px;
}

.overview-card {
  padding: 22px;
  position: sticky;
  top: 96px;
}

.overview-list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.overview-list li {
  align-items: center;
  background: #f7f9fc;
  border: 1px solid #e8eef5;
  border-radius: 12px;
  display: flex;
  gap: 14px;
  margin-bottom: 12px;
  padding: 13px;
}

.overview-list i {
  align-items: center;
  background: #eef2fa;
  border-radius: 12px;
  color: #1f4079;
  display: flex;
  flex: 0 0 44px;
  height: 44px;
  justify-content: center;
  width: 44px;
}

.overview-list span {
  color: #718096;
  display: block;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
}

.overview-list strong {
  color: #2C2D3F;
  display: block;
  font-size: 14px;
  margin-top: 2px;
}

.apply-button {
  margin-top: 12px;
  width: 100%;
}

.privacy-note {
  color: #718096;
  font-size: 13px;
  font-weight: 400;
  margin: 14px 0 0;
  text-align: center;
}

.privacy-note i {
  color: #1f4079;
  margin-right: 7px;
}

.apply-modal {
  align-items: center;
  background: rgba(13, 24, 39, 0.58);
  bottom: 0;
  display: flex;
  justify-content: center;
  left: 0;
  padding: 20px;
  position: fixed;
  right: 0;
  top: 0;
  z-index: 1050;
}

.modal-shell {
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
  max-width: 560px;
  padding: 24px;
  width: 100%;
}

.modal-header {
  align-items: flex-start;
  border: 0;
  display: flex;
  justify-content: space-between;
  padding: 0;
}

.modal-header h3 {
  font-size: 22px;
  font-weight: 600;
  margin: 0 0 20px;
}

.modal-header button {
  align-items: center;
  background: #f3f6fa;
  border: 0;
  border-radius: 12px;
  color: #526173;
  display: flex;
  height: 42px;
  justify-content: center;
  width: 42px;
}

.application-form {
  display: grid;
  gap: 14px;
}

.application-form label {
  margin: 0;
}

.application-form span {
  color: #526173;
  display: block;
  font-size: 13px;
  font-weight: 500;
  margin-bottom: 7px;
}

.application-form input {
  background: #f7f9fc;
  border: 1px solid #e8eef5;
  border-radius: 12px;
  color: #2C2D3F;
  min-height: 46px;
  outline: 0;
  padding: 10px 14px;
  width: 100%;
}

.form-actions {
  display: grid;
  gap: 12px;
  grid-template-columns: 1fr 1fr;
  margin-top: 8px;
}

.cancel-button {
  background: #f3f6fa;
  border: 0;
  border-radius: 12px;
  color: #526173;
  font-size: 14px;
  font-weight: 500;
}

.success-box {
  background: #ebfbf1;
  border: 1px solid #ccefd8;
  border-radius: 12px;
  color: #237447;
  font-weight: 500;
  padding: 16px;
}

.page-loader {
  align-items: center;
  display: flex;
  justify-content: center;
  min-height: 70vh;
}

@media (max-width: 991px) {
  .detail-hero {
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    padding-bottom: 88px;
  }

  .hero-card {
    grid-template-columns: 1fr;
  }

  .role-mark {
    height: 62px;
    width: 62px;
  }

  .overview-card {
    position: static;
  }
}

@media (max-width: 575px) {
  .role-intro h1 {
    font-size: 30px;
    line-height: 36px;
  }

  .content-card,
  .overview-card,
  .hero-card,
  .modal-shell {
    border-radius: 15px;
  }

  .content-card,
  .overview-card {
    padding: 22px;
  }

  .detail-content {
    margin-top: -46px;
  }

  .form-actions {
    grid-template-columns: 1fr;
  }
}
</style>
