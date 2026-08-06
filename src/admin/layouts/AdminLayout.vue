<script setup>
import { onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue';
import logo from '@images/logo.svg?raw';
import NavbarThemeSwitcher from '@/admin/layouts_sneat/components/NavbarThemeSwitcher.vue';
import UserProfile from '@/admin/layouts_sneat/components/UserProfile.vue';
import { useAuth } from '@/admin/composables/useAuth';

const router = useRouter();
const { hasPermission, initAuth, isInitialized } = useAuth();

onMounted(async () => {
  await initAuth();
});
</script>

<template>
  <div v-if="!isInitialized" class="d-flex h-screen align-center justify-center">
     <VProgressCircular indeterminate color="primary" />
  </div>
  <VerticalNavLayout v-else>
    <template #navbar="{ toggleVerticalOverlayNavActive }">
      <div class="d-flex h-100 align-center">
        <!-- 👉 Vertical nav toggle in overlay mode -->
        <IconBtn class="ms-n3 d-lg-none" @click="toggleVerticalOverlayNavActive(true)">
          <VIcon icon="bx-menu" />
        </IconBtn>

        <!-- 👉 Search -->
        <div class="d-flex align-center cursor-pointer ms-lg-n3" style="user-select: none;">
          <IconBtn>
            <VIcon icon="bx-search" />
          </IconBtn>
          <span class="d-none d-md-flex align-center text-disabled ms-2">
            <span class="me-2">Search</span>
            <span class="meta-key">&#8984;K</span>
          </span>
        </div>

        <VSpacer />

        <NavbarThemeSwitcher class="me-1" />
        <UserProfile />
      </div>
    </template>

    <template #vertical-nav-header="{ toggleIsOverlayNavActive }">
      <RouterLink to="/admin" class="app-logo app-title-wrapper">
        <div class="d-flex" v-html="logo" />
        <h1 class="app-logo-title">Admin</h1>
      </RouterLink>

      <IconBtn class="d-block d-lg-none" @click="toggleIsOverlayNavActive(false)">
        <VIcon icon="bx-x" />
      </IconBtn>
    </template>

    <template #vertical-nav-content>
      <VList class="nav-items">
        <VListItem to="/admin" prepend-icon="bi-house-door" title="Dashboard"></VListItem>
        <VListItem v-if="hasPermission('view categories')" to="/admin/categories" prepend-icon="bi-list-ul" title="Categories"></VListItem>
        <VListItem v-if="hasPermission('view industry-types')" to="/admin/industry-types" prepend-icon="bi-briefcase" title="Industry Types"></VListItem>
        <VListItem to="/admin/job-types" prepend-icon="bi-bookmark-star" title="Job Types"></VListItem>
        <VListItem v-if="hasPermission('view clients')" to="/admin/clients" prepend-icon="bi-building" title="Clients"></VListItem>
        <VListItem v-if="hasPermission('view jobs')" to="/admin/jobs" prepend-icon="bi-briefcase" title="Jobs"></VListItem>
        <VListItem v-if="hasPermission('view applications')" to="/admin/applications" prepend-icon="bi-file-earmark" title="Applications"></VListItem>
        <VListItem v-if="hasPermission('view skills')" to="/admin/tools" prepend-icon="bi-wrench" title="Skills"></VListItem>
        <VListItem v-if="hasPermission('view currencies')" to="/admin/currencies" prepend-icon="bi-cash-stack" title="Currencies"></VListItem>
        
        <VListGroup v-if="hasPermission('view roles') || hasPermission('view users')" value="Access Control">
          <template #activator="{ props }">
            <VListItem v-bind="props" prepend-icon="bi-shield-lock" title="Access Control" />
          </template>

          <VListItem v-if="hasPermission('view roles')" to="/admin/roles" prepend-icon="bi-key" title="Roles & Permissions" />
          <VListItem v-if="hasPermission('view users')" to="/admin/users" prepend-icon="bi-person" title="Users" />
        </VListGroup>
      </VList>
    </template>

    <VContainer fluid>
      <RouterView />
    </VContainer>

  </VerticalNavLayout>
</template>

<style lang="scss" scoped>
.meta-key {
  border: thin solid rgba(var(--v-border-color), var(--v-border-opacity));
  border-radius: 6px;
  block-size: 1.5625rem;
  line-height: 1.3125rem;
  padding-block: 0.125rem;
  padding-inline: 0.25rem;
}

.app-logo {
  display: flex;
  align-items: center;
  column-gap: 0.75rem;

  .app-logo-title {
    font-size: 1.25rem;
    font-weight: 500;
    line-height: 1.75rem;
    text-transform: uppercase;
  }
}
</style>
