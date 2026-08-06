<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuth } from '@/admin/composables/useAuth';

const { hasPermission } = useAuth();

const applications = ref([]);
const categories = ref([]);
const jobs = ref([]);
const loading = ref(false);

const filters = ref({
    search: '',
    category_id: null,
    job_id: null
});

const fetchApplications = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/job-applications', { params: filters.value });
        applications.value = response.data;
    } catch (e) { console.error(e); } finally { loading.value = false; }
}

const deleteApplication = async (id) => {
    if (confirm('Delete this application record?')) {
        try {
            await axios.delete(`/job-applications/${id}`);
            fetchApplications();
        } catch (e) { console.error(e); }
    }
}

const fetchMetadata = async () => {
    try {
        const [catsRes, jobsRes] = await Promise.all([
            axios.get('/job-categories'),
            axios.get('/jobs')
        ]);
        categories.value = catsRes.data;
        jobs.value = jobsRes.data;
    } catch (e) { console.error(e); }
}

onMounted(() => {
    fetchApplications();
    fetchMetadata();
});
</script>

<template>
  <VRow>
    <VCol cols="12">
      <!-- Filter Card -->
      <VCard class="mb-6">
        <VCardText>
          <VRow>
            <VCol cols="12" sm="4">
              <AppTextField
                v-model="filters.search"
                label="Search Keywords"
                placeholder="Name, Phone, Email"
                prepend-inner-icon="bi-search"
                @update:modelValue="fetchApplications"
              />
            </VCol>
            <VCol cols="12" sm="4">
              <AppSelect2
                v-model="filters.category_id"
                :items="categories"
                item-title="name"
                item-value="id"
                label="Filter Category"
                @update:modelValue="fetchApplications"
              />
            </VCol>
            <VCol cols="12" sm="4">
              <AppSelect2
                v-model="filters.job_id"
                :items="jobs"
                item-title="title"
                item-value="id"
                label="Filter Job Position"
                @update:modelValue="fetchApplications"
              />
            </VCol>
          </VRow>
        </VCardText>
      </VCard>

      <VCard title="Applicant Tracking" subtitle="Review incoming job applications">
        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Applicant', key: 'name' },
              { title: 'Contact', key: 'email' },
              { title: 'Position', key: 'job.title' },
              { title: 'Resume', key: 'resume', sortable: false },
              { title: 'Date', key: 'created_at' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'end' }
            ]"
            :items="applications"
            :loading="loading"
          >
            <template #item.name="{ item }">
              <div class="d-flex flex-column">
                <span class="font-weight-bold">{{ item.name }}</span>
                <span class="text-caption text-secondary">{{ item.phone }}</span>
              </div>
            </template>

            <template #item.resume="{ item }">
              <VBtn
                v-if="item.resume_url"
                size="small"
                variant="tonal"
                color="primary"
                prepend-icon="bi-download"
                :href="item.resume_url"
                target="_blank"
              >Download</VBtn>
              <span v-else class="text-caption text-secondary">No Resume</span>
            </template>

            <template #item.actions="{ item }">
              <div class="d-flex gap-2 justify-end">
                <VBtn v-if="hasPermission('delete applications')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteApplication(item.id)">Delete</VBtn>
              </div>
            </template>

            <template #item.created_at="{ item }">
              <span class="text-caption">{{ new Date(item.created_at).toLocaleDateString() }}</span>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
