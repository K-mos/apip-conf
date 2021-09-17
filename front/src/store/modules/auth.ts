import { Module } from 'vuex';
import { AuthApi } from '@/api/security/AuthApi';
import { IAuthState, IRootState, IAuthRequest, IAuthResponse, IUserPayload } from '@/interfaces';
import { setRefreshToken } from '@/utils/LocalStorageUtil';

export const auth: Module<IAuthState, IRootState> = {
  namespaced: true,
  state: (): IAuthState => ({
    permissions: [],
    user: null,
  }),
  getters: {
    can: (state: IAuthState) => (code: string): boolean => state.permissions.includes(code),
    isLogged: (state: IAuthState): boolean => !!state.user,
    permissions: (state: IAuthState): string[] => state.permissions,
    user: (state: IAuthState): IUserPayload | null => state.user,
  },
  actions: {
    async LOGIN_REQUEST({ commit }, user?: IAuthRequest): Promise<any> {
      commit('LOGIN_REQUEST');
      if (!user) {
        return Promise.resolve();
      }

      const res = await new AuthApi().login(user);
      commit('LOGIN_SUCCESS', res.data);

      return res;
    },

    async REFRESH_TOKEN({ commit }): Promise<any> {
      const res = await new AuthApi().refreshToken();
      commit('LOGIN_SUCCESS', res.data);

      return res;
    },
  },
  mutations: {
    LOGIN_REQUEST(state: IAuthState) {
      state.user = null;
      setRefreshToken(null);
    },
    LOGIN_SUCCESS(state: IAuthState, resp: IAuthResponse) {
      state.user = resp.user;
      state.permissions = resp.permissions;
      setRefreshToken(resp.refresh_token);
    },
  },
}
