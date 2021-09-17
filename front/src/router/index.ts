import { createRouter, createWebHistory } from 'vue-router';
import { routes } from './routes';
import { secureApp } from './security';

declare module 'vue-router' {
  interface RouteMeta {
    permission?: string;
    actions?: string[];
    requiresAuth?: boolean
  }
}

export const router = createRouter({
  history: createWebHistory(),
  routes,
})

secureApp(router);
