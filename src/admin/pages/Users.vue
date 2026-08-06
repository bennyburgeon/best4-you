<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useAuth } from '@/admin/composables/useAuth'

const users = ref([])
const rolesList = ref([])
const loading = ref(false)
const dialog = ref(false)
const { hasPermission } = useAuth()

const editedItem = ref({ name: '', email: '', password: '', roles: [] })
const editedIndex = ref(-1)

const fetchUsers = async () => {
  loading.value = true
  try {
    const response = await axios.get('/users')
    users.value = response.data
  } catch (e) {
    console.error(e)
  } finally {
    loading.value = false
  }
}

const fetchRoles = async () => {
    try {
        const response = await axios.get('/roles')
        rolesList.value = response.data
    } catch (e) { console.error(e) }
}

const save = async () => {
  try {
    if (editedIndex.value > -1) {
      await axios.put(`/users/${editedItem.value.id}`, editedItem.value)
    } else {
      await axios.post('/users', editedItem.value)
    }
    fetchUsers()
    close()
  } catch (e) {
    console.error(e)
  }
}

const deleteItem = async (item) => {
  if (confirm('Are you sure you want to delete this user?')) {
    try {
      await axios.delete(`/users/${item.id}`)
      fetchUsers()
    } catch (e) {
      console.error(e)
    }
  }
}

const editItem = (item) => {
  editedIndex.value = users.value.indexOf(item)
  editedItem.value = { 
      ...item, 
      password: '',
      roles: item.roles ? item.roles.map(r => r.name) : [] 
  }
  dialog.value = true
}

const close = () => {
  dialog.value = false
  editedItem.value = { name: '', email: '', password: '', roles: [] }
  editedIndex.value = -1
}

onMounted(() => {
    fetchUsers()
    fetchRoles()
})
</script>

<template>
  <VRow>
    <VCol cols="12">
      <VCard title="User Management" subtitle="Manage admin panel users and their roles">
        <template #append v-if="hasPermission('create users')">
          <VBtn color="primary" prepend-icon="bi-person-plus" @click="dialog = true">Add User</VBtn>
        </template>

        <VCardText>
          <VDataTable
            :headers="[
              { title: 'Name', key: 'name' },
              { title: 'Email', key: 'email' },
              { title: 'Roles', key: 'roles_list' },
              { title: 'Actions', key: 'actions', sortable: false, align: 'end' }
            ]"
            :items="users"
            :loading="loading"
          >
            <template #item.roles_list="{ item }">
              <div class="d-flex flex-wrap gap-1">
                  <VChip v-for="role in item.roles" :key="role.id" size="x-small" color="info" variant="flat">
                    {{ role.name }}
                  </VChip>
                  <span v-if="!item.roles || item.roles.length === 0" class="text-caption text-disabled">No Role</span>
              </div>
            </template>

            <template #item.actions="{ item }">
              <div class="d-flex gap-2 justify-end">
                <VBtn v-if="hasPermission('edit users')" size="small" variant="tonal" color="info" prepend-icon="bi-pencil-square" @click="editItem(item)">Edit</VBtn>
                <VBtn v-if="hasPermission('delete users')" size="small" variant="tonal" color="error" prepend-icon="bi-trash" @click="deleteItem(item)">Delete</VBtn>
              </div>
            </template>
          </VDataTable>
        </VCardText>
      </VCard>

      <VDialog v-model="dialog" max-width="600px">
        <VCard :title="editedIndex > -1 ? 'Edit User' : 'New User'">
          <VCardText>
            <VRow>
              <VCol cols="12">
                <AppTextField v-model="editedItem.name" label="Full Name" />
              </VCol>
              <VCol cols="12">
                <AppTextField v-model="editedItem.email" label="Email Address" type="email" />
              </VCol>
              <VCol cols="12">
                <AppTextField v-model="editedItem.password" label="Password" type="password" :placeholder="editedIndex > -1 ? 'Leave blank to keep current' : ''" />
              </VCol>
              <VCol cols="12">
                  <AppSelect2
                    v-model="editedItem.roles"
                    :items="rolesList"
                    item-title="name"
                    item-value="name"
                    label="Assign Roles"
                    multiple
                    chips
                  />
              </VCol>
            </VRow>
          </VCardText>
          <VCardActions class="pa-4">
            <VSpacer />
            <VBtn color="secondary" variant="text" @click="close">Cancel</VBtn>
            <VBtn color="primary" variant="elevated" @click="save">Save User</VBtn>
          </VCardActions>
        </VCard>
      </VDialog>
    </VCol>
  </VRow>
</template>
