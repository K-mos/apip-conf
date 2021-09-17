export default [
  {
    path: '/users',
    name: 'users',
    meta: {
      permission: 'api_users_get_collection',
      actions: ['api_users_post_collection', 'api_users_get_item', 'api_users_put_item'],
    },
    component: () => import('@/views/Users.vue'),
  },
  {
    path: '/organizations',
    name: 'organizations',
    meta: {
      permission: 'api_organizations_get_collection',
    },
    component: () => import('@/views/Organizations.vue'),
  },
  {
    path: '/services',
    name: 'services',
    meta: {
      permission: 'api_services_get_collection',
    },
    component: () => import('@/views/Services.vue'),
  },
];
