<script setup>
import { ref } from 'vue';
import axios from '@/admin/utils/axios';
import { useRouter } from 'vue-router';
import logo from '@images/logo.svg?raw';
import authV1BottomShape from '@images/svg/auth-v1-bottom-shape.svg?url';
import authV1TopShape from '@images/svg/auth-v1-top-shape.svg?url';
import { useAuth } from '@/admin/composables/useAuth';

const router = useRouter();
const form = ref({
    email: '',
    password: '',
    remember: false,
});

const isPasswordVisible = ref(false);
const error = ref('');
const loading = ref(false);
const { user, roles, permissions } = useAuth();

const login = async () => {
    loading.value = true;
    error.value = '';
    try {
        await axios.get('/sanctum/csrf-cookie', { baseURL: '/' });
        const response = await axios.post('/auth/login', {
            email: form.value.email,
            password: form.value.password,
        });
        
        // Populate the useAuth shared state manually after login
        user.value = response.data.user;
        roles.value = response.data.roles || [];
        permissions.value = response.data.permissions || [];
        
        router.push('/admin');
    } catch (e) {
        error.value = e.response?.data?.message || 'Login failed.';
    } finally {
        loading.value = false;
    }
};
</script>

<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <div class="position-relative my-sm-16">
      <!-- 👉 Top shape -->
      <VImg
        :src="authV1TopShape"
        class="text-primary auth-v1-top-shape d-none d-sm-block"
      />

      <!-- 👉 Bottom shape -->
      <VImg
        :src="authV1BottomShape"
        class="text-primary auth-v1-bottom-shape d-none d-sm-block"
      />

      <!-- 👉 Auth Card -->
      <VCard
        class="auth-card"
        max-width="460"
        :class="$vuetify.display.smAndUp ? 'pa-6' : 'pa-0'"
      >
        <VCardItem class="justify-center">
          <RouterLink
            to="/"
            class="app-logo"
          >
            <div
              class="d-flex"
              v-html="logo"
            />
            <h1 class="app-logo-title">
              B4U ADMIN
            </h1>
          </RouterLink>
        </VCardItem>

        <VCardText>
          <h4 class="text-h4 mb-1">
            Welcome to B4U! 👋🏻
          </h4>
          <p class="mb-0">
            Please sign-in to your account and start managing jobs
          </p>
        </VCardText>

        <VCardText>
          <VAlert v-if="error" type="error" class="mb-4" variant="tonal" closable>{{ error }}</VAlert>

          <VForm @submit.prevent="login">
            <VRow>
              <!-- email -->
              <VCol cols="12">
                <VTextField
                  v-model="form.email"
                  autofocus
                  label="Email"
                  type="email"
                  placeholder="admin@example.com"
                />
              </VCol>

              <!-- password -->
              <VCol cols="12">
                <VTextField
                  v-model="form.password"
                  label="Password"
                  placeholder="············"
                  :type="isPasswordVisible ? 'text' : 'password'"
                  autocomplete="password"
                  :append-inner-icon="isPasswordVisible ? 'bi-eye-slash' : 'bi-eye'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible"
                />

                <!-- remember me checkbox -->
                <div class="d-flex align-center justify-space-between flex-wrap my-6">
                  <VCheckbox
                    v-model="form.remember"
                    label="Remember me"
                  />
                  <a class="text-primary" href="javascript:void(0)">Forgot Password?</a>
                </div>

                <!-- login button -->
                <VBtn
                  block
                  type="submit"
                  :loading="loading"
                >
                  Login
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </div>
  </div>
</template>

<style lang="scss">
@use "@core/scss/template/pages/page-auth";
</style>
