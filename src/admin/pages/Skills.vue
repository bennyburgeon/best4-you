<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuth } from '@/admin/composables/useAuth'

const { hasPermission } = useAuth();

const skills = ref([])
const loading = ref(false)
const dialog = ref(false)
const editedItem = ref({ name: '' })
const editedIndex = ref(-1)

const fetchSkills = async () => {
  loading.value = true
  try {
    const response = await axios.get('/skills')
    skills.value = response.data
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

const save = async () => {
  try {
    if (editedIndex.value > -1) {
      await axios.put(`/skills/${editedItem.value.id}`, editedItem.value)
    } else {
      await axios.post('/skills', editedItem.value)
    }
    fetchSkills()
    close()
  } catch (e) {
    console.error(e)
  }
}

const deleteItem = async (item) => {
  if (confirm('Are you sure you want to delete this skill?')) {
    try {
      await axios.delete(`/skills/${item.id}`)
      fetchSkills()
    } catch (e) {
      console.error(e)
    }
  }
}

const editItem = (item) => {
  editedIndex.value = skills.value.indexOf(item)
  editedItem.value = { ...item }
  dialog.value = true
}

const close = () => {
  dialog.value = false
  editedItem.value = { name: '' }
  editedIndex.value = -1
}

onMounted(fetchSkills)
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Master Skills" subtitle="Manage key skills for job postings">
        <template #append v-if="hasPermission('create skills')">
          <VBtn color="primary" prepend-icon="bi-plus" @click="dialog = true">Add Skill</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Skill Name', key: 'name' },
              { title: 'Date Created', key: 'created_at' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'end' }
            ]"
            :items="skills"
            :loading="loading"
          >
            <template #item.created_at="{ item }">
              {{ new Date(item.created_at).toLocaleDateString() }}
            </template>

            <template #item.actions="{ item }">
              <div class="d-flex gap-2 justify-end">
                <VBtn v-if="hasPermission('edit skills')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="editItem(item)">Edit</VBtn>
                <VBtn v-if="hasPermission('delete skills')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item)">Delete</VBtn>
              </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>

      <VDialog v-model="dialog" max-width="500px">
        <VCard :title="editedIndex > -1 ? 'Edit Skill' : 'New Skill'">
          <VCardText>
            <AppTextField v-model="editedItem.name" label="Skill Name" placeholder="e.g. PHP, Vue.js, Project Management" />
          </VCardText>
          <VCardActions>
            <VSpacer />
            <VBtn color="secondary" variant="text" @click="close">Cancel</VBtn>
            <VBtn color="primary" @click="save">Save</VBtn>
          </VCardActions>
        </VCard>
      </VDialog>
    </VCol>
  </VRow>
</template>
