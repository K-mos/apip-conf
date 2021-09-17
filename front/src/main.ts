import { createApp } from 'vue';
import { defineRule } from 'vee-validate';
import { email, required } from '@vee-validate/rules';
import '@/assets/scss/global.scss';
import { router } from '@/router';
import { store } from '@/store';
import App from '@/App.vue';

defineRule('required', required);
defineRule('email', email);

createApp(App)
  .use(router)
  .use(store)
  .mount('#app')
