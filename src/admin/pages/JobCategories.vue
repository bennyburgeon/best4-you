<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuth } from '@/admin/composables/useAuth';

const { hasPermission } = useAuth();

const categories = ref([]);
const loading = ref(false);
const dialog = ref(false);
const editedItem = ref({ id: null, name: '', symbol: '', parent_category_id: null });

const fetchCategories = async () => {
    loading.value = true;
    try {
        const response = await axios.get('/job-categories');
        categories.value = response.data;
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
        editedItem.value = { id: null, name: '', symbol: '', parent_category_id: null };
    }
    dialog.value = true;
}

const save = async () => {
    try {
        if (editedItem.value.id) {
            await axios.put(`/job-categories/${editedItem.value.id}`, editedItem.value);
        } else {
            await axios.post('/job-categories', editedItem.value);
        }
        dialog.value = false;
        fetchCategories();
    } catch (e) {
        console.error(e);
    }
}

const deleteItem = async (id) => {
    if (confirm('Are you sure you want to delete this category?')) {
        try {
            await axios.delete(`/job-categories/${id}`);
            fetchCategories();
        } catch (e) {
            console.error(e);
        }
    }
}

onMounted(fetchCategories);
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Job Categories" subtitle="Manage your hierarchical job clusters">
        <template #append v-if="hasPermission('create categories')">
          <VBtn prepend-icon="bi-plus" color="primary" @click="openDialog()">Add Category</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'ID', key: 'id' },
              { title: 'Name', key: 'name' },
              { title: 'Symbol', key: 'symbol' },
              { title: 'Parent', key: 'parent.name' },
              { title: 'Actions', key: 'actions', sortable: false }
            ]"
            :items="categories"
            :loading="loading"
          >
            <template #item.actions="{ item }">
              <div class="d-flex gap-2">
                <VBtn v-if="hasPermission('edit categories')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="openDialog(item)">Edit</VBtn>
                <VBtn v-if="hasPermission('delete categories')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item.id)">Delete</VBtn>
              </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>
    </VCol>

    <!-- Modal -->
    <VDialog v-model="dialog" max-width="500">
      <VCard :title="editedItem.id ? 'Edit Category' : 'New Category'">
        <VCardText>
          <VRow>
            <VCol cols="12" md="8">
              <AppTextField v-model="editedItem.name" label="Category Name" placeholder="e.g., Information Technology" />
            </VCol>
            <VCol cols="12" md="4">
              <AppTextField v-model="editedItem.symbol" label="Symbol" placeholder="e.g., IT" />
            </VCol>
            <VCol cols="12">
              <AppSelect2
                v-model="editedItem.parent_category_id"
                :items="categories.filter(c => c.id !== editedItem.id)"
                item-title="name"
                item-value="id"
                label="Parent Category (Optional)"
              />
            </VCol>
          </VRow>
        </VCardText>
        <VCardActions>
          <VSpacer />
          <VBtn color="secondary" variant="tonal" @click="dialog = false">Cancel</VBtn>
          <VBtn color="primary" @click="save">Save Changes</VBtn>
        </VCardActions>
      </VCard>
    </VDialog>
  </VRow>
</template>
