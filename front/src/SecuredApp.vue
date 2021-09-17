<template>
  <NavBar />
  <section class="section">
    <router-view :key="$route.fullPath" />
  </section>
</template>

<script setup lang="ts">
import { onMounted, onDeactivated } from 'vue';
import { useRoute } from 'vue-router';
import NavBar from '@/components/ui/NavBar.vue';
import { useMercure } from '@/composables/useMercure';
import { redirectNoAuthorized } from "@/router/security";

const currentRoute = useRoute();
const { subscribePermissions, unsubscribePermissions } = useMercure(() => redirectNoAuthorized(currentRoute));

onMounted(() => subscribePermissions());
onDeactivated(() => unsubscribePermissions());
</script>
