<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const stats = ref({
    jobs: 0,
    applications: 0,
    clients: 0,
    categories: 0
});

const fetchStats = async () => {
    try {
        const response = await axios.get('/dashboard/stats');
        stats.value = response.data;
    } catch (e) {
        console.error(e);
    }
}

onMounted(fetchStats);
</script>

<template>
  <VRow>
    <VCol cols="12" md="8">
      <VCard title="Congratulations Admin! 🎉" subtitle="You've made another successful day." class="mb-4 shadow-sm">
        <VCardText>
          <div class="d-flex align-center gap-4">
             <div class="bg-primary-subtle p-3 rounded-lg"><VIcon size="48" color="primary" icon="bi-trophy" /></div>
             <div>
                <h4 class="text-h4 font-weight-bold">{{ stats.applications }} New Applications</h4>
                <p class="mb-0 text-secondary">Check your new applicant records in the applications module.</p>
                <VBtn class="mt-4" color="primary" variant="elevated" to="/admin/applications">View Applications</VBtn>
             </div>
          </div>
        </VCardText>
      </VCard>
    </VCol>

    <VCol cols="12" md="4">
      <VCard title="Brief Overview" subtitle="System Metrics" class="h-100 shadow-sm">
         <VCardText>
            <VRow>
               <VCol cols="6" class="border-e border-b pa-4 d-flex flex-column align-center">
                  <VIcon size="32" color="info" icon="bi-briefcase" class="mb-2" />
                  <span class="text-h5 font-weight-bold">{{ stats.jobs }}</span>
                  <span class="text-caption text-secondary">Live Jobs</span>
               </VCol>
               <VCol cols="6" class="border-b pa-4 d-flex flex-column align-center">
                  <VIcon size="32" color="success" icon="bi-megaphone" class="mb-2" />
                  <span class="text-h5 font-weight-bold">{{ stats.applications }}</span>
                  <span class="text-caption text-secondary">Applications</span>
               </VCol>
               <VCol cols="6" class="border-e pa-4 d-flex flex-column align-center">
                  <VIcon size="32" color="warning" icon="bi-building" class="mb-2" />
                  <span class="text-h5 font-weight-bold">{{ stats.clients }}</span>
                  <span class="text-caption text-secondary">Partners</span>
               </VCol>
               <VCol cols="6" class="pa-4 d-flex flex-column align-center">
                  <VIcon size="32" color="primary" icon="bi-list-ul" class="mb-2" />
                  <span class="text-h5 font-weight-bold">{{ stats.categories }}</span>
                  <span class="text-caption text-secondary">Categories</span>
               </VCol>
            </VRow>
         </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>
