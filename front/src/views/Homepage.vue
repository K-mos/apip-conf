<template>
  <p>{{ currentUser.firstname }},</p>
</template>

<script lang="ts" setup>
import { useCurrentUser } from '@/composables/useCurrentUser';

const { currentUser } = useCurrentUser();
</script>
