<template>
  <Form
    v-slot="{ meta }"
    @submit="login"
  >
    <InputField
      label="Email"
      name="email"
      rules="required|email"
      type="email"
    />
    <InputField
      label="Password"
      name="password"
      rules="required"
      type="password"
    />
    <div class="field has-text-centered">
      <SubmitButton
        label="Submit"
        :disabled="!meta.valid"
      />
    </div>
  </Form>
</template>

<script lang="ts" setup>
import { Form } from 'vee-validate';
import { useRoute, useRouter } from 'vue-router';
import { useStore } from 'vuex';
import InputField from '@/components/ui/form/InputField.vue';
import SubmitButton from '@/components/ui/button/SubmitButton.vue';
import { IUserPayload } from '@/interfaces';

const store = useStore();
const router = useRouter();
const route = useRoute();

const login = async (user: IUserPayload) => {
  await store.dispatch('auth/LOGIN_REQUEST', user);
  const redirect = route.query.redirect || '/';
  try {
    await router.push({ path: `${redirect}` });
  } catch (e) {
    await router.push({ path: '/' });
  }
}
</script>
