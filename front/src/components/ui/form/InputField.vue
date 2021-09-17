<template>
  <div class="field">
    <label class="label">{{ label }}</label>
    <div class="control">
      <Field
        class="input"
        :label="label"
        :name="name"
        :type="type"
        :rules="rules"
        :placeholder="placeholder"
      />
      <ErrorMessage
        class="help is-danger"
        :name="name"
      />
    </div>
  </div>
</template>

<script setup>
import { ErrorMessage, Field } from 'vee-validate';

defineEmits(['update:modelValue']);

defineProps({
  type: {
    type: String,
    default: 'text',
  },
  name: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    default: '',
  },
  rules: {
    type: String,
    default: null,
  },
});
</script>
