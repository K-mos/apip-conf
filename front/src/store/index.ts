import { createStore } from 'vuex';
import modules from './modules';

export const store = createStore({
  state () {
    return {
      version: '1.0.0',
    }
  },
  modules,
});
