import auth from '@/router/routes/auth';
import pages from '@/router/routes/pages';

export const routes = [
  ...auth,
  {
    component: () => import('@/SecuredApp.vue'),
    meta: { requiresAuth: true },
    path: '/',
    children: [
      {
        path: '/',
        name: 'homepage',
        component: () => import('@/views/Homepage.vue'),
      },
      ...pages,
    ],
  },
];
