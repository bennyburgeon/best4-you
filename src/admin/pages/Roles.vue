<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuth } from '@/admin/composables/useAuth'

const roles = ref([])
const permissionsList = ref([])
const loading = ref(false)
const dialog = ref(false)
const { hasPermission } = useAuth()

const editedItem = ref({ name: '', permissions: [] })
const editedIndex = ref(-1)

const fetchRoles = async () => {
  loading.value = true
  try {
    const response = await axios.get('/roles')
    roles.value = response.data
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

const fetchPermissions = async () => {
    try {
        const response = await axios.get('/permissions')
        permissionsList.value = response.data
    } catch (e) { console.error(e) }
}

const save = async () => {
  try {
    const payload = {
        name: editedItem.value.name,
        permissions: editedItem.value.permissions
    }
    if (editedIndex.value > -1) {
      await axios.put(`/roles/${editedItem.value.id}`, payload)
    } else {
      await axios.post('/roles', payload)
    }
    fetchRoles()
    close()
  } catch (e) {
    console.error(e)
  }
}

const deleteItem = async (item) => {
  if (confirm('Are you sure you want to delete this role?')) {
    try {
      await axios.delete(`/roles/${item.id}`)
      fetchRoles()
    } catch (e) {
      console.error(e)
    }
  }
}

const editItem = (item) => {
  editedIndex.value = roles.value.indexOf(item)
  editedItem.value = { 
      id: item.id,
      name: item.name, 
      permissions: item.permissions ? item.permissions.map(p => p.name) : [] 
  }
  dialog.value = true
}

const close = () => {
  dialog.value = false
  editedItem.value = { name: '', permissions: [] }
  editedIndex.value = -1
}

onMounted(() => {
    fetchRoles()
    fetchPermissions()
})
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="Roles & Permissions" subtitle="Manage user access levels">
        <template #append v-if="hasPermission('create roles')">
          <VBtn color="primary" prepend-icon="bi-plus" @click="dialog = true">Add Role</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Role Name', key: 'name' },
              { title: 'Permissions Count', key: 'perms_count' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'end' }
            ]"
            :items="roles"
            :loading="loading"
          >
            <template #item.perms_count="{ item }">
              <VChip size="small" color="primary" variant="tonal">
                  {{ item.permissions ? item.permissions.length : 0 }} Permissions
              </VChip>
            </template>

            <template #item.actions="{ item }">
              <div class="d-flex gap-2 justify-end">
                <VBtn v-if="hasPermission('edit roles')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="editItem(item)">Edit</VBtn>
                <VBtn v-if="hasPermission('delete roles') && item.name !== 'super-admin'" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item)">Delete</VBtn>
              </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>

      <VDialog v-model="dialog" max-width="700px">
        <VCard :title="editedIndex > -1 ? 'Edit Role' : 'New Role'">
          <VCardText>
            <VRow>
              <VCol cols="12">
                <AppTextField v-model="editedItem.name" label="Role Name" placeholder="e.g. HR Manager" :disabled="editedItem.name === 'super-admin'" />
              </VCol>
              
              <VCol cols="12">
                  <p class="text-subtitle-2 mb-2">Assign Permissions</p>
                  <VRow>
                      <VCol v-for="perm in permissionsList" :key="perm.id" cols="12" sm="6" md="4">
                          <VCheckbox
                            v-model="editedItem.permissions"
                            :label="perm.name"
                            :value="perm.name"
                            density="compact"
                            hide-details
                          />
                      </VCol>
                  </VRow>
              </VCol>
            </VRow>
          </VCardText>
          <VCardActions class="pa-4">
            <VSpacer />
            <VBtn color="secondary" variant="text" @click="close">Cancel</VBtn>
            <VBtn color="primary" variant="elevated" @click="save">Save Role</VBtn>
          </VCardActions>
        </VCard>
      </VDialog>
    </VCol>
  </VRow>
</template>
