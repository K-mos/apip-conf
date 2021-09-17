<template>
  <h1 class="title">Users</h1>
  <TableListing
    :headers="headers"
    endpoint="users"
  />
  <ListActions />
</template>

<script setup lang="ts">
import ListActions from "@/components/ui/list/ListActions.vue";
import TableListing from '@/components/ui/list/TableListing.vue';

const headers = ['firstname', 'lastname', 'email'];
</script>
