<template>
  <h1 class="title">Organizations</h1>
  <TableListing
    :headers="headers"
    endpoint="organizations"
  />
</template>

<script setup lang="ts">
import TableListing from '@/components/ui/list/TableListing.vue';

const headers = ['name'];
</script>
