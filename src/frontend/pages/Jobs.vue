<template>
  <div class="jobs-page">
    <section class="jobs-hero">
      <div class="container">
        <div class="row align-items-center g-4">
          <div class="col-lg-7">
            <span class="hero-kicker">BestForYou Careers</span>
            <h1>Find a role that fits your next chapter.</h1>
            <p>
              Explore curated openings, compare role details quickly, and apply with confidence.
            </p>
          </div>
          <div class="col-lg-5">
            <div class="hero-stats">
              <div>
                <strong>{{ jobs.length }}</strong>
                <span>Open roles</span>
              </div>
              <div>
                <strong>{{ uniqueLocations }}</strong>
                <span>Locations</span>
              </div>
              <div>
                <strong>{{ uniqueCategories }}</strong>
                <span>Categories</span>
              </div>
            </div>
          </div>
        </div>

        <form class="search-dock" @submit.prevent="fetchJobs">
          <label class="search-field">
            <i class="fa fa-search"></i>
            <span>What</span>
            <input
              v-model="filters.search"
              type="text"
              placeholder="Job title, skill, keyword"
              @keyup.enter="fetchJobs"
            >
          </label>
          <label class="search-field">
            <i class="fa fa-map-marker"></i>
            <span>Where</span>
            <input
              v-model="filters.location"
              type="text"
              placeholder="City, state, remote"
              @keyup.enter="fetchJobs"
            >
          </label>
          <button type="submit" class="search-button">
            Search Jobs
            <i class="fa fa-arrow-right"></i>
          </button>
        </form>
      </div>
    </section>

    <section class="jobs-content">
      <div class="container">
        <div v-if="loading" class="loading-state">
          <div class="spinner-grow text-primary" role="status"></div>
          <p>Curating opportunities...</p>
        </div>

        <div v-else class="row g-4 align-items-start">
          <aside class="col-xl-3 col-lg-4">
            <div class="filter-panel">
              <div class="panel-heading">
                <span>Refine Search</span>
                <button
                  v-if="filters.search || filters.location || filters.category_id"
                  type="button"
                  @click="clearFilters"
                >
                  Clear
                </button>
              </div>

              <label class="panel-input">
                <span>Keywords</span>
                <input v-model="filters.search" type="text" placeholder="UI designer, sales, PHP">
              </label>

              <label class="panel-input">
                <span>Location</span>
                <input v-model="filters.location" type="text" placeholder="Kozhikode, Kochi, Remote">
              </label>

              <div class="panel-category">
                <span>Category</span>
                <div class="category-options">
                  <button
                    type="button"
                    :class="{ active: !filters.category_id }"
                    @click="setCategory('')"
                  >
                    All categories
                  </button>
                  <button
                    v-for="category in categories"
                    :key="category.id"
                    type="button"
                    :class="{ active: String(filters.category_id) === String(category.id) }"
                    @click="setCategory(category.id)"
                  >
                    {{ category.name }}
                  </button>
                </div>
              </div>

              <button type="button" class="panel-button" @click="fetchJobs">
                Apply Filters
              </button>

              <div class="support-card">
                <i class="fa fa-file-text-o"></i>
                <h3>Stand out faster</h3>
                <p>Upload your resume and let our recruiters match you with relevant openings.</p>
                <router-link to="/upload-resume">Upload Resume</router-link>
              </div>
            </div>
          </aside>

          <div class="col-xl-9 col-lg-8">
            <div class="results-toolbar">
              <div>
                <span class="eyebrow">Available opportunities</span>
                <h2>{{ jobs.length }} {{ jobs.length === 1 ? 'role' : 'roles' }} found</h2>
              </div>
              <div class="toolbar-note">
                <i class="fa fa-bolt"></i>
                Updated regularly
              </div>
            </div>

            <div v-if="jobs.length" class="job-list">
              <article v-for="job in jobs" :key="job.id" class="job-card">
                <div class="job-card-accent"></div>
                <div class="company-mark">
                  {{ initials(job.title) }}
                </div>

                <div class="job-card-main">
                  <div class="job-meta-top">
                    <span v-if="job.job_code" class="code-pill"><i class="fa fa-hashtag"></i>{{ job.job_code }}</span>
                    <span class="category-pill">{{ job.category?.name || 'General' }}</span>
                    <span v-if="job.job_type" class="type-pill"><i class="fa fa-star"></i>{{ job.job_type?.name }}</span>
                    <span><i class="fa fa-clock-o"></i>{{ formatDaysAgo(job.posted_days_ago) }}</span>
                  </div>

                  <h3>
                    <router-link :to="{ name: 'job-details', params: { id: job.id }}">
                      {{ job.title }}
                    </router-link>
                  </h3>

                  <div class="job-facts">
                    <span><i class="fa fa-map-marker"></i>{{ job.location || 'Remote' }}</span>
                    <span><i class="fa fa-briefcase"></i>{{ experienceLabel(job) }}</span>
                    <span><i class="fa fa-money"></i>{{ salaryLabel(job) }}</span>
                  </div>

                  <div class="skills-row">
                    <span v-for="skill in job.skills?.slice(0, 5)" :key="skill.id">{{ skill.name }}</span>
                    <span v-if="job.skills?.length > 5" class="more-skills">+{{ job.skills.length - 5 }} more</span>
                    <span v-if="!job.skills || job.skills.length === 0" class="muted-skill">Skills not listed</span>
                  </div>
                </div>

                <div class="job-card-action">
                  <router-link :to="{ name: 'job-details', params: { id: job.id }}" class="details-button">
                    View Details
                    <i class="fa fa-arrow-right"></i>
                  </router-link>
                </div>
              </article>
            </div>

            <div v-else class="empty-state">
              <div class="empty-icon"><i class="fa fa-search"></i></div>
              <h3>No matching jobs found</h3>
              <p>Try another keyword, location, or reset the filters to see every open role.</p>
              <button type="button" @click="clearFilters">Reset Search</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const jobs = ref([]);
const categories = ref([]);
const loading = ref(true);

const filters = ref({
  search: route.query.q || '',
  location: route.query.location || '',
  category_id: route.query.category_id || '',
});

const uniqueLocations = computed(() => {
  return new Set(jobs.value.map(job => job.location).filter(Boolean)).size || 1;
});

const uniqueCategories = computed(() => categories.value.length || 1);

const fetchCategories = async () => {
  try {
    const res = await axios.get('/job-categories');
    categories.value = res.data.sort((a, b) => a.name.localeCompare(b.name));
  } catch (e) {
    console.error(e);
  }
};

const activeFilterParams = () => ({
  ...(filters.value.search ? { search: filters.value.search } : {}),
  ...(filters.value.location ? { location: filters.value.location } : {}),
  ...(filters.value.category_id ? { category_id: filters.value.category_id } : {}),
});

const fetchJobs = async (syncRoute = true) => {
  loading.value = true;
  try {
    const params = activeFilterParams();
    const res = await axios.get('/jobs', { params });
    jobs.value = res.data;
    if (syncRoute) {
      router.replace({
        path: '/jobs',
        query: {
          ...(filters.value.search ? { q: filters.value.search } : {}),
          ...(filters.value.location ? { location: filters.value.location } : {}),
          ...(filters.value.category_id ? { category_id: filters.value.category_id } : {}),
        },
      });
    }
  } catch (e) {
    console.error(e);
  } finally {
    loading.value = false;
  }
};

const clearFilters = () => {
  filters.value = { search: '', location: '', category_id: '' };
  router.replace({ path: '/jobs' });
  fetchJobs();
};

const setCategory = (categoryId) => {
  filters.value.category_id = categoryId;
};

const formatDaysAgo = (days) => {
  if (days === null || days === undefined) return 'Recently posted';
  const numDays = Math.floor(days);
  if (numDays === 0) return 'Just now';
  if (numDays === 1) return '1 day ago';
  return `${numDays} days ago`;
};

const experienceLabel = (job) => {
  if (job.experience_min !== null && job.experience_min !== undefined) {
    return `${job.experience_min}-${job.experience_max} Yrs`;
  }
  return 'Any experience';
};

const salaryLabel = (job) => {
  if (job.salary_from && job.salary_to && job.currency) {
    return `${job.currency.symbol}${job.salary_from} - ${job.currency.symbol}${job.salary_to}`;
  }
  return job.salary || 'Competitive';
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

watch(() => route.query, (newQuery) => {
  filters.value.search = newQuery.q || '';
  filters.value.location = newQuery.location || '';
  filters.value.category_id = newQuery.category_id || '';
  fetchJobs(false);
});

onMounted(() => {
  fetchCategories();
  fetchJobs();
});
</script>

<style scoped>
.jobs-page {
  background: #f4f7fb;
  color: #2C2D3F;
  font-size: 14px;
  min-height: 100vh;
}

.jobs-hero {
  background:
    linear-gradient(135deg, rgba(31, 64, 121, 0.92), rgba(44, 45, 63, 0.74)),
    url('/frontend/assets/img/slider3.webp') center/cover;
  border-bottom-left-radius: 25px;
  border-bottom-right-radius: 25px;
  color: #fff;
  padding: 70px 0 95px;
  position: relative;
}

.hero-kicker,
.eyebrow {
  color: #1f4079;
  display: inline-flex;
  font-size: 13px;
  font-weight: 600;
  letter-spacing: 0;
  text-transform: uppercase;
}

.jobs-hero .hero-kicker {
  color: #fff;
  margin-bottom: 12px;
}

.jobs-hero h1 {
  font-size: 38px;
  font-weight: 700;
  letter-spacing: 0;
  line-height: 42px;
  margin-bottom: 15px;
  max-width: 650px;
}

.jobs-hero p {
  color: rgba(255, 255, 255, 0.82);
  font-size: 14px;
  line-height: 24px;
  margin: 0;
  max-width: 560px;
}

.hero-stats {
  background: rgba(255, 255, 255, 0.14);
  border: 1px solid rgba(255, 255, 255, 0.24);
  border-radius: 20px;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
  display: grid;
  gap: 12px;
  grid-template-columns: repeat(3, 1fr);
  padding: 12px;
}

.hero-stats div {
  background: rgba(255, 255, 255, 0.13);
  border-radius: 15px;
  padding: 16px 10px;
  text-align: center;
}

.hero-stats strong,
.hero-stats span {
  display: block;
}

.hero-stats strong {
  font-size: 28px;
  line-height: 1;
}

.hero-stats span {
  color: rgba(255, 255, 255, 0.78);
  font-size: 13px;
  margin-top: 7px;
}

.search-dock {
  align-items: stretch;
  background: #fff;
  border-radius: 50px;
  box-shadow: 0 15px 35px rgba(18, 45, 78, 0.18);
  display: grid;
  gap: 6px;
  grid-template-columns: 1fr 1fr auto;
  margin-top: 35px;
  padding: 6px 6px 6px 20px;
}

.search-field {
  align-items: center;
  background: #f3f7fb;
  border: 1px solid #e6eef6;
  border-radius: 40px;
  display: grid;
  gap: 2px 12px;
  grid-template-columns: auto 1fr;
  margin: 0;
  padding: 10px 14px;
}

.search-field i {
  color: #1f4079;
  grid-row: span 2;
}

.search-field span,
.panel-input span {
  color: #718096;
  font-size: 12px;
  font-weight: 500;
  text-transform: uppercase;
}

.search-field input,
.panel-input input,
.panel-input select {
  background: transparent;
  border: 0;
  color: #2C2D3F;
  font-size: 14px;
  font-weight: 400;
  min-width: 0;
  outline: 0;
  width: 100%;
}

.search-button,
.panel-button,
.empty-state button,
.details-button {
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
  padding: 13px 25px;
  text-decoration: none;
  transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
}

.search-button:hover,
.panel-button:hover,
.empty-state button:hover,
.details-button:hover {
  background: #2C2D3F;
  box-shadow: 0 10px 22px rgba(31, 64, 121, 0.2);
  color: #fff;
  transform: translateY(-2px);
}

.jobs-content {
  margin-top: -62px;
  padding-bottom: 70px;
  position: relative;
}

.filter-panel,
.job-card,
.empty-state,
.results-toolbar {
  background: #fff;
  border: 1px solid #e6edf5;
  border-radius: 15px;
  box-shadow: 0 10px 30px rgba(32, 48, 73, 0.08);
}

.filter-panel {
  padding: 20px;
  position: sticky;
  top: 96px;
}

.panel-heading,
.results-toolbar,
.job-meta-top,
.job-facts,
.skills-row {
  align-items: center;
  display: flex;
  flex-wrap: wrap;
}

.panel-heading {
  justify-content: space-between;
  margin-bottom: 18px;
}

.panel-heading span {
  font-size: 18px;
  font-weight: 600;
}

.panel-heading button {
  background: #fff1f1;
  border: 0;
  border-radius: 999px;
  color: #d64242;
  font-size: 13px;
  font-weight: 500;
  padding: 6px 12px;
}

.panel-input {
  background: #f7f9fc;
  border: 1px solid #e8eef5;
  border-radius: 12px;
  display: block;
  margin-bottom: 14px;
  padding: 11px 14px;
}

.panel-category {
  margin-bottom: 14px;
}

.panel-category > span {
  color: #718096;
  display: block;
  font-size: 12px;
  font-weight: 500;
  margin-bottom: 9px;
  text-transform: uppercase;
}

.category-options {
  display: grid;
  gap: 8px;
  max-height: 230px;
  overflow-y: auto;
  padding-right: 3px;
}

.category-options button {
  align-items: center;
  background: #f7f9fc;
  border: 1px solid #e8eef5;
  border-radius: 12px;
  color: #526173;
  display: flex;
  font-size: 14px;
  font-weight: 500;
  justify-content: space-between;
  line-height: 20px;
  min-height: 42px;
  padding: 10px 13px;
  text-align: left;
  transition: all 0.2s ease;
  width: 100%;
}

.category-options button::after {
  border: 1px solid #cbd5e1;
  border-radius: 50%;
  content: "";
  flex: 0 0 14px;
  height: 14px;
  margin-left: 10px;
  width: 14px;
}

.category-options button:hover {
  border-color: rgba(31, 64, 121, 0.35);
  color: #1f4079;
}

.category-options button.active {
  background: #eef2fa;
  border-color: rgba(31, 64, 121, 0.35);
  color: #1f4079;
}

.category-options button.active::after {
  background: #1f4079;
  border-color: #1f4079;
  box-shadow: inset 0 0 0 3px #fff;
}

.panel-button {
  min-height: 46px;
  width: 100%;
}

.support-card {
  background: #f6f8fb;
  border-radius: 15px;
  margin-top: 20px;
  padding: 20px;
}

.support-card i {
  color: #1f4079;
  font-size: 24px;
}

.support-card h3 {
  font-size: 18px;
  font-weight: 600;
  margin: 12px 0 8px;
}

.support-card p {
  color: #65758b;
  font-size: 14px;
  line-height: 24px;
}

.support-card a {
  color: #1f4079;
  font-weight: 500;
}

.results-toolbar {
  justify-content: space-between;
  margin-bottom: 18px;
  padding: 18px 22px;
}

.results-toolbar h2 {
  font-size: 24px;
  font-weight: 600;
  margin: 5px 0 0;
}

.toolbar-note {
  background: #f0fbf5;
  border-radius: 999px;
  color: #228a53;
  font-size: 13px;
  font-weight: 500;
  padding: 8px 14px;
}

.job-list {
  display: grid;
  gap: 18px;
}

.job-card {
  display: grid;
  gap: 22px;
  grid-template-columns: auto 1fr auto;
  overflow: hidden;
  padding: 22px;
  position: relative;
  transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.job-card:hover {
  border-color: rgba(31, 64, 121, 0.25);
  box-shadow: 0 15px 35px rgba(32, 48, 73, 0.12);
  transform: translateY(-3px);
}

.job-card-accent {
  background: linear-gradient(180deg, #1f4079, #d81f34);
  border-radius: 0 999px 999px 0;
  bottom: 22px;
  left: 0;
  position: absolute;
  top: 22px;
  width: 6px;
}

.company-mark {
  align-items: center;
  background: #eef2fa;
  border: 1px solid #dfe6f2;
  border-radius: 15px;
  color: #1f4079;
  display: flex;
  font-weight: 600;
  height: 56px;
  justify-content: center;
  width: 56px;
}

.job-meta-top {
  gap: 12px;
  margin-bottom: 12px;
}

.job-meta-top span:not(.category-pill) {
  color: #718096;
  font-size: 13px;
  font-weight: 400;
}

.job-meta-top i,
.job-facts i {
  color: #1f4079;
  margin-right: 7px;
}

.category-pill,
.code-pill,
.type-pill {
  border-radius: 999px;
  font-size: 12px;
  font-weight: 600;
  padding: 7px 12px;
  text-transform: uppercase;
}

.category-pill {
  background: #eef2fa;
  color: #1f4079;
}

.code-pill {
  background: #f1f5f9;
  color: #475569;
}

.type-pill {
  background: #fff1f2;
  color: #e11d48;
}

.job-card h3 {
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 11px;
}

.job-card h3 a {
  color: #2C2D3F;
  text-decoration: none;
}

.job-card h3 a:hover {
  color: #1f4079;
}

.job-facts {
  color: #526173;
  gap: 12px 22px;
  font-size: 14px;
  font-weight: 400;
  margin-bottom: 16px;
}

.skills-row {
  gap: 8px;
}

.skills-row span {
  background: #f3f6fa;
  border-radius: 999px;
  color: #536275;
  font-size: 13px;
  font-weight: 500;
  padding: 7px 11px;
}

.skills-row .more-skills {
  background: #fff7e7;
  color: #9a6a09;
}

.skills-row .muted-skill {
  background: transparent;
  color: #8a98a8;
  padding-left: 0;
}

.job-card-action {
  align-items: center;
  display: flex;
}

.details-button {
  min-height: 44px;
  padding: 10px 18px;
  white-space: nowrap;
}

.empty-state,
.loading-state {
  padding: 55px 24px;
  text-align: center;
}

.loading-state {
  color: #65758b;
}

.loading-state p {
  font-weight: 500;
  margin-top: 16px;
}

.empty-icon {
  align-items: center;
  background: #eef2fa;
  border-radius: 15px;
  color: #1f4079;
  display: flex;
  font-size: 28px;
  height: 74px;
  justify-content: center;
  margin: 0 auto 20px;
  width: 74px;
}

.empty-state h3 {
  font-size: 24px;
  font-weight: 600;
}

.empty-state p {
  color: #65758b;
  margin: 8px auto 24px;
  max-width: 520px;
}

.empty-state button {
  min-height: 44px;
  padding: 10px 22px;
}

@media (max-width: 991px) {
  .jobs-hero {
    border-bottom-left-radius: 20px;
    border-bottom-right-radius: 20px;
    padding: 60px 0 88px;
  }

  .search-dock,
  .job-card {
    grid-template-columns: 1fr;
  }

  .search-button {
    min-height: 48px;
  }

  .filter-panel {
    position: static;
  }

  .company-mark {
    height: 52px;
    width: 52px;
  }

  .job-card-action {
    justify-content: flex-start;
  }
}

@media (max-width: 575px) {
  .jobs-hero h1 {
    font-size: 30px;
    line-height: 36px;
  }

  .hero-stats {
    grid-template-columns: 1fr;
  }

  .jobs-content {
    margin-top: -46px;
  }

  .filter-panel,
  .job-card,
  .empty-state,
  .results-toolbar {
    border-radius: 15px;
  }

  .results-toolbar {
    align-items: flex-start;
    gap: 12px;
  }
}
</style>
