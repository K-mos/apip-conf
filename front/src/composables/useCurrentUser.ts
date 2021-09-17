import { computed } from 'vue';
import { useStore } from 'vuex';
import { IUserPayload } from '@/interfaces';

export const useCurrentUser = () => {
  const store = useStore();
  const currentUser = computed<IUserPayload>(() => store.getters['auth/user']);

  return { currentUser };
}
