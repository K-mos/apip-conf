<template>
  <button
    :class="['button', 'is-dark', { 'is-loading': loading }]"
    type="button"
    @click="fetchAll"
  >
    Fetch all
  </button>
  <h2>{{ total }} items found.</h2>
  <table class="table is-hoverable is-striped is-fullwidth" v-if="items.length">
    <thead>
    <tr>
      <th v-for="header in headers" :key="header">{{ header }}</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="item in items" :key="item['@id']">
      <td v-for="header in headers" :key="header">{{ item[header] }}</td>
    </tr>
    </tbody>
  </table>
</template>

<script lang="ts" setup>
import { IUser } from '@/interfaces';
import { useItemsFetch } from '@/composables/useItemsFetch';

const props = defineProps({
  headers: {
    type: Array,
    required: true,
  },
  endpoint: {
    type: String,
    required: true,
  },
});
const { items, total, loading, fetchAll } = useItemsFetch<IUser>(props.endpoint);
</script>
