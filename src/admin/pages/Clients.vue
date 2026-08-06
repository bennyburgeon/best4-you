<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuth } from '@/admin/composables/useAuth';

const { hasPermission } = useAuth();

const clients = ref([]);
const loading = ref(false);
const dialog = ref(false);
const dropzoneFile = ref(null);
const editedItem = ref({ 
    id: null, 
    title: '', 
    verified: false,
    hr_name: '',
    hr_contact: '',
    hr_email: ''
});

const fetchClients = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/clients');
        clients.value = response.data;
    } catch (e) {
        console.error(e);
    } finally {
        loading.value = false;
    }
}

const openDialog = (item = null) => {
    if (item) {
        editedItem.value = { 
            ...item, 
            verified: !!item.verified,
            hr_name: item.hr_name || '',
            hr_contact: item.hr_contact || '',
            hr_email: item.hr_email || ''
        };
    } else {
        editedItem.value = { 
            id: null, 
            title: '', 
            verified: false,
            hr_name: '',
            hr_contact: '',
            hr_email: ''
        };
    }
    dropzoneFile.value = null;
    dialog.value = true;
}

const save = async () => {
    try {
        const formData = new FormData();
        Object.keys(editedItem.value).forEach(key => {
            if (editedItem.value[key] !== null && key !== 'verified') {
                formData.append(key, editedItem.value[key]);
            }
        });
        
        // Convert boolean to 1/0 for Laravel's boolean validator when using FormData
        formData.append('verified', editedItem.value.verified ? 1 : 0);

        if (dropzoneFile.value) {
            formData.append('logo', dropzoneFile.value);
        }

        if (editedItem.value.id) {
            formData.append('_method', 'PUT');
            await axios.post(`/clients/${editedItem.value.id}`, formData);
        } else {
            await axios.post('/clients', formData);
        }
        dialog.value = false;
        fetchClients();
    } catch (e) {
        console.error(e);
    }
}

const deleteItem = async (id) => {
    if (confirm('Delete this client?')) {
        try {
            await axios.delete(`/clients/${id}`);
            fetchClients();
        } catch (e) {
            console.error(e);
        }
    }
}

onMounted(fetchClients);
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Clients / Partners" subtitle="Trust partners and organizations">
        <template #append v-if="hasPermission('create clients')">
          <VBtn prepend-icon="bi-plus-circle" color="primary" @click="openDialog()">Add Client</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Logo', key: 'logo', sortable: false },
              { title: 'Title', key: 'title' },
              { title: 'Verified', key: 'verified' },
              { title: 'Actions', key: 'actions', sortable: false }
            ]"
            :items="clients"
            :loading="loading"
          >
            <template #item.logo="{ item }">
              <VAvatar size="48" rounded="lg" color="light-primary" v-if="item.logo">
                <VImg :src="item.logo" />
              </VAvatar>
              <VAvatar size="48" rounded="lg" color="light-primary" v-else icon="bi-building" />
            </template>

            <template #item.verified="{ item }">
              <VChip :color="item.verified ? 'success' : 'secondary'" size="small" variant="tonal" class="text-uppercase font-weight-bold">
                {{ item.verified ? 'Verified' : 'Pending' }}
              </VChip>
            </template>

            <template #item.actions="{ item }">
               <div class="d-flex gap-2">
                 <VBtn v-if="hasPermission('edit clients')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="openDialog(item)">Edit</VBtn>
                 <VBtn v-if="hasPermission('delete clients')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item.id)">Delete</VBtn>
               </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>
    </VCol>

    <VDialog v-model="dialog" max-width="600">
      <VCard :title="editedItem.id ? 'Edit Client Profile' : 'New Client Profile'">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <AppTextField v-model="editedItem.title" label="Company / Client Name" prepend-inner-icon="bi-building" />
            </VCol>
            
            <VCol cols="12">
              <p class="text-overline mb-2">HR Contact Details</p>
              <VDivider class="mb-4" />
            </VCol>

            <VCol cols="12" md="4">
              <AppTextField v-model="editedItem.hr_name" label="HR Name" placeholder="Full name" prepend-inner-icon="bi-person" />
            </VCol>
            <VCol cols="12" md="4">
              <AppTextField v-model="editedItem.hr_contact" label="HR Contact" placeholder="Phone number" prepend-inner-icon="bi-telephone" />
            </VCol>
            <VCol cols="12" md="4">
              <AppTextField v-model="editedItem.hr_email" label="HR Email" placeholder="Email address" prepend-inner-icon="bi-envelope" />
            </VCol>

            <VCol cols="12">
              <AppDropzone v-model="dropzoneFile" label="Client Logo" accepted-files="image/*" />
            </VCol>
            <VCol cols="12">
               <VSwitch v-model="editedItem.verified" label="Verified Status" color="success" />
            </VCol>
          </VRow>
        </VCardText>
        <VCardActions class="pa-4">
          <VSpacer />
          <VBtn color="secondary" @click="dialog = false" variant="text">Discard</VBtn>
          <VBtn color="primary" variant="elevated" @click="save">Save Partner</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>
  </VRow>
</template>
