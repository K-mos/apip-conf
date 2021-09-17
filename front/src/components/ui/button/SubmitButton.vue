<template>
  <div class="control">
    <button
      :class="['button', type]"
      :disabled="disabled"
      type="submit"
    >
      {{ label }}
    </button>
  </div>
</template>

<script setup>
defineProps({
  type: {
    type: String,
    default: 'is-primary',
  },
  label: {
    type: String,
    required: true,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});
</script>
