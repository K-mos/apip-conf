<template>
  <nav class="navbar is-fixed-top is-dark" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
      <router-link :to="{ path: '/' }" class="navbar-item">
        <img
          src="~@/assets/logo-text.png"
          alt="Home page"
        >
      </router-link>
    </div>

    <div class="navbar-menu">
      <div class="navbar-start">
        <router-link :to="{ name: 'homepage' }" class="navbar-item">
          Home
        </router-link>

        <router-link
          :to="{ name: 'users' }"
          class="navbar-item"
          v-if="can('api_users_get_collection')"
        >
          Users
        </router-link>

        <router-link
          :to="{ name: 'organizations' }"
          class="navbar-item"
          v-if="can('api_organizations_get_collection')"
        >
          Organizations
        </router-link>

        <router-link
          :to="{ name: 'services' }"
          class="navbar-item"
          v-if="can('api_services_get_collection')"
        >
          Services
        </router-link>
      </div>

      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <a @click="logout" class="button is-danger">
              <strong>Logout</strong>
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { logout } from '@/utils/LocalStorageUtil';
import { useStore } from "vuex";

const store = useStore();
const can = (code: string) => store.getters['auth/can'](code);
</script>
