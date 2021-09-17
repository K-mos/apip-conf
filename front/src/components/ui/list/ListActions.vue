<template>
  <div
    class="buttons"
    v-if="authorizedActions.length"
  >
    <button
      v-for="action in authorizedActions"
      :key="action"
      class="button is-primary"
    >
      {{ action }}
    </button>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";

const store = useStore();
const can = (code: string) => store.getters['auth/can'](code);

const route = useRoute();
const authorizedActions = computed(() => route.meta.actions?.filter((action) => can(action)) || [])
</script>
