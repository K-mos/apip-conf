<template>
  <section class="section">
    <div class="container">
      <section class="card">
        <div class="card-header-icon">
          <figure class="image is-128x128">
            <img
              src="~@/assets/logo.png"
              alt="API Platform"
            >
          </figure>
        </div>

        <div class="card-header">
          <h1 class="card-header-title is-centered">
            Login to continue
          </h1>
        </div>

        <div class="card-content">
          <LoginForm />
        </div>
      </section>
    </div>
  </section>
</template>

<script lang="ts" setup>
import { onMounted } from 'vue';
import { useStore } from 'vuex';
import LoginForm from '@/components/security/LoginForm.vue';

const store = useStore();
onMounted(() => store.dispatch('auth/LOGIN_REQUEST'));
</script>

<style scoped>
.card { width: 600px; margin: auto; }
</style>
