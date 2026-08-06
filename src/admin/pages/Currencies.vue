<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuth } from '@/admin/composables/useAuth'

const { hasPermission } = useAuth();

const currencies = ref([])
const loading = ref(false)
const dialog = ref(false)
const editedItem = ref({ name: '', code: '', symbol: '' })
const editedIndex = ref(-1)

const fetchCurrencies = async () => {
  loading.value = true
  try {
    const response = await axios.get('/currencies')
    currencies.value = response.data
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

const save = async () => {
  try {
    if (editedIndex.value > -1) {
      await axios.put(`/currencies/${editedItem.value.id}`, editedItem.value)
    } else {
      await axios.post('/currencies', editedItem.value)
    }
    fetchCurrencies()
    close()
  } catch (e) {
    console.error(e)
  }
}

const deleteItem = async (item) => {
  if (confirm('Are you sure you want to delete this currency?')) {
    try {
      await axios.delete(`/currencies/${item.id}`)
      fetchCurrencies()
    } catch (e) {
      console.error(e)
    }
  }
}

const editItem = (item) => {
  editedIndex.value = currencies.value.indexOf(item)
  editedItem.value = { ...item }
  dialog.value = true
}

const close = () => {
  dialog.value = false
  editedItem.value = { name: '', code: '', symbol: '' }
  editedIndex.value = -1
}

onMounted(fetchCurrencies)
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Currencies" subtitle="Manage master data for currencies">
        <template #append v-if="hasPermission('create currencies')">
          <VBtn color="primary" prepend-icon="bi-plus" @click="dialog = true">Add Currency</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Currency Name', key: 'name' },
              { title: 'Code', key: 'code' },
              { title: 'Symbol', key: 'symbol' },
              { title: 'Date Created', key: 'created_at' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'end' }
            ]"
            :items="currencies"
            :loading="loading"
          >
            <template #item.created_at="{ item }">
              {{ new Date(item.created_at).toLocaleDateString() }}
            </template>

            <template #item.actions="{ item }">
              <div class="d-flex gap-2 justify-end">
                <VBtn v-if="hasPermission('edit currencies')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="editItem(item)">Edit</VBtn>
                <VBtn v-if="hasPermission('delete currencies')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item)">Delete</VBtn>
              </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>

      <VDialog v-model="dialog" max-width="500px">
        <VCard :title="editedIndex > -1 ? 'Edit Currency' : 'New Currency'">
          <VCardText>
            <VRow>
              <VCol cols="12">
                <AppTextField v-model="editedItem.name" label="Currency Name" placeholder="e.g. Indian Rupee" />
              </VCol>
              <VCol cols="6">
                <AppTextField v-model="editedItem.code" label="Currency Code" placeholder="e.g. INR" />
              </VCol>
              <VCol cols="6">
                <AppTextField v-model="editedItem.symbol" label="Symbol" placeholder="e.g. ₹" />
              </VCol>
            </VRow>
          </VCardText>
          <VCardActions class="pa-4">
            <VSpacer />
            <VBtn color="secondary" variant="text" @click="close">Cancel</VBtn>
            <VBtn color="primary" variant="elevated" @click="save">Save</VBtn>
          </VCardActions>
        </VCard>
      </VDialog>
    </VCol>
  </VRow>
</template>
