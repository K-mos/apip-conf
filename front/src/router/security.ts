import { router } from "@/router/index";
import { RouteLocation, Router } from 'vue-router';
import { store } from '@/store';

export const canAccessRoute = (route: RouteLocation): boolean => {
  const { permission } = route.meta;
  const can = (code: string) => store.getters['auth/can'](code);

  return !!(!permission || can(permission));
};

export const redirectNoAuthorized = (currentRoute: RouteLocation) => {
  if (!canAccessRoute(currentRoute)) {
    router.push({ path: '/' });
  }
}

export const secureApp = (router: Router) => {
  router.beforeEach(async (to, from, next) => {
    if (!to.matched.some((record) => record.meta.requiresAuth)) {
      return next();
    }

    if (!store.getters['auth/isLogged']) {
      try {
        await store.dispatch('auth/REFRESH_TOKEN');
      } catch(e) {
        return next({ path: '/login', query: { redirect: to.fullPath } });
      }
    }

    if (canAccessRoute(to)) {
      return next();
    }

    return next({ path: '/' });
  });
};
