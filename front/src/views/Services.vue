<template>
  <h1 class="title">Services</h1>
  <TableListing
    :headers="headers"
    endpoint="services"
  />
</template>

<script setup lang="ts">
import TableListing from '@/components/ui/list/TableListing.vue';

const headers = ['name'];
</script>
