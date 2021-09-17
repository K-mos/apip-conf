import { subscribe } from '@/api/mercure';
import { store } from '@/store';

export const useMercure = (cb: Function) => {
  let stateEvent: EventSource|null = null;
  const subscribePermissions = async () => {
    stateEvent = subscribe(async () => {
      await store.dispatch('auth/REFRESH_TOKEN');
      cb();
    });
  }

  const unsubscribePermissions = () => {
    stateEvent = null;
  }

  return {
    subscribePermissions,
    unsubscribePermissions,
  }
}
