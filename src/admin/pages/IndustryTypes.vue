<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuth } from '@/admin/composables/useAuth';

const { hasPermission } = useAuth();
const industryTypes = ref([]);
const loading = ref(false);
const dialog = ref(false);
const editedItem = ref({ id: null, name: '' });

const fetchIndustryTypes = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/industry-types');
        industryTypes.value = response.data;
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
            await axios.put(`/industry-types/${editedItem.value.id}`, editedItem.value);
        } else {
            await axios.post('/industry-types', editedItem.value);
        }
        dialog.value = false;
        fetchIndustryTypes();
    } catch (e) {
        console.error(e);
    }
}

const deleteItem = async (id) => {
    if (confirm('Delete this industry type?')) {
        try {
            await axios.delete(`/industry-types/${id}`);
            fetchIndustryTypes();
        } catch (e) {
            console.error(e);
        }
    }
}

onMounted(fetchIndustryTypes);
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Industry Types" subtitle="Manage job industries">
        <template #append v-if="hasPermission('create industry-types')">
          <VBtn prepend-icon="bi-plus-circle" color="primary" @click="openDialog()">Add Industry</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Name', key: 'name' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'right' }
            ]"
            :items="industryTypes"
            :loading="loading"
          >
            <template #item.actions="{ item }">
               <div class="d-flex gap-2 justify-end">
                 <VBtn v-if="hasPermission('edit industry-types')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="openDialog(item)">Edit</VBtn>
                 <VBtn v-if="hasPermission('delete industry-types')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item.id)">Delete</VBtn>
               </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>
    </VCol>

    <VDialog v-model="dialog" max-width="500">
      <VCard :title="editedItem.id ? 'Edit Industry Type' : 'New Industry Type'">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <AppTextField v-model="editedItem.name" label="Industry Name" placeholder="e.g. IT, Healthcare, Finance" />
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
