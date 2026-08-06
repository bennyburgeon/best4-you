<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuth } from '@/admin/composables/useAuth';

const { hasPermission } = useAuth();
const jobTypes = ref([]);
const loading = ref(false);
const dialog = ref(false);
const editedItem = ref({ id: null, name: '' });

const fetchJobTypes = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/job-types');
        jobTypes.value = response.data;
    } catch (e) {
        console.error(e);
    } finally {
        loading.value = false;
    }
}

const openDialog = (item = null) => {
    if (item) {
        editedItem.value = { ...item };
    } else {
        editedItem.value = { id: null, name: '' };
    }
    dialog.value = true;
}

const save = async () => {
    try {
        if (editedItem.value.id) {
            await axios.put(`/job-types/${editedItem.value.id}`, editedItem.value);
        } else {
            await axios.post('/job-types', editedItem.value);
        }
        dialog.value = false;
        fetchJobTypes();
    } catch (e) {
        console.error(e);
    }
}

const deleteItem = async (id) => {
    if (confirm('Delete this job type?')) {
        try {
            await axios.delete(`/job-types/${id}`);
            fetchJobTypes();
        } catch (e) {
            console.error(e);
        }
    }
}

onMounted(fetchJobTypes);
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Job Types" subtitle="Manage employment types (Full Time, Part Time, etc.)">
        <template #append v-if="hasPermission('create job-types')">
          <VBtn prepend-icon="bi-plus-circle" color="primary" @click="openDialog()">Add Job Type</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Name', key: 'name' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'right' }
            ]"
            :items="jobTypes"
            :loading="loading"
          >
            <template #item.actions="{ item }">
               <div class="d-flex gap-2 justify-end">
                 <VBtn v-if="hasPermission('edit job-types')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="openDialog(item)">Edit</VBtn>
                 <VBtn v-if="hasPermission('delete job-types')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item.id)">Delete</VBtn>
               </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>
    </VCol>

    <VDialog v-model="dialog" max-width="500">
      <VCard :title="editedItem.id ? 'Edit Job Type' : 'New Job Type'">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <AppTextField v-model="editedItem.name" label="Job Type Name" placeholder="e.g. Full Time, Contract, Freelance" />
            </VCol>
          </VRow>
        </VCardText>
        <VCardActions class="pa-4">
          <VSpacer />
          <VBtn color="secondary" @click="dialog = false" variant="text">Discard</VBtn>
          <VBtn color="primary" variant="elevated" @click="save">Save</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>
  </VRow>
</template>
