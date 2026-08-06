<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuth } from '@/admin/composables/useAuth';

const { hasPermission } = useAuth();
const regions = ref([]);
const loading = ref(false);
const dialog = ref(false);
const editedItem = ref({ id: null, name: '', status: true });

const fetchRegions = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/regions');
        // Handle both flat array and DataTables object format robustly
        regions.value = Array.isArray(response.data) ? response.data : (response.data.data || []);
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
        editedItem.value = { id: null, name: '', status: true };
    }
    dialog.value = true;
}

const save = async () => {
    try {
        const payload = {
            ...editedItem.value,
            status: editedItem.value.status ? 1 : 0
        };
        
        if (editedItem.value.id) {
            await axios.put(`/regions/${editedItem.value.id}`, payload);
        } else {
            await axios.post('/regions', payload);
        }
        dialog.value = false;
        fetchRegions();
    } catch (e) {
        console.error(e);
    }
}

const deleteItem = async (id) => {
    if (confirm('Are you sure you want to delete this region?')) {
        try {
            await axios.delete(`/regions/${id}`);
            fetchRegions();
        } catch (e) {
            console.error(e);
        }
    }
}

onMounted(fetchRegions);
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Regions" subtitle="Manage geographic regions for job listings">
        <template #append v-if="hasPermission('create regions') || true">
          <VBtn prepend-icon="bi-plus-circle" color="primary" @click="openDialog()">Add Region</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'ID', key: 'id' },
              { title: 'Name', key: 'name' },
              { title: 'Slug', key: 'slug' },
              { title: 'Status', key: 'status' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'right' }
            ]"
            :items="regions"
            :loading="loading"
          >
            <template #item.status="{ item }">
              <VChip :color="item.status ? 'success' : 'error'" size="small">
                {{ item.status ? 'Active' : 'Inactive' }}
              </VChip>
            </template>

            <template #item.actions="{ item }">
               <div class="d-flex gap-2 justify-end">
                 <VBtn size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="openDialog(item)">Edit</VBtn>
                 <VBtn size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item.id)">Delete</VBtn>
               </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>
    </VCol>

    <VDialog v-model="dialog" max-width="500">
      <VCard :title="editedItem.id ? 'Edit Region' : 'New Region'">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <VTextField v-model="editedItem.name" label="Region Name" placeholder="e.g. India, Gulf, Europe" />
            </VCol>
            <VCol cols="12">
              <VSwitch v-model="editedItem.status" label="Active Status" color="success" />
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
