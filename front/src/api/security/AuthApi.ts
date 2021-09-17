import { axiosInstance } from '@/api/axios';
import { IAuthRequest } from '@/interfaces';
import { getRefreshToken } from '@/utils/LocalStorageUtil';

export let refreshing = false;

export class AuthApi {
  login(user: IAuthRequest) {
    return axiosInstance.post('login_check', user);
  }

  async refreshToken() {
    const refresh_token = getRefreshToken();
    if (!refresh_token) {
      return Promise.reject();
    }

    refreshing = true;
    const res = await axiosInstance.post('token/refresh', { refresh_token });
    refreshing = false;

    return res;
  }
}
