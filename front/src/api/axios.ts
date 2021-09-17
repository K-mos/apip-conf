import axios from 'axios';
import { store } from '@/store';
import { logout } from '@/utils/LocalStorageUtil';
import { refreshing } from './security/AuthApi';

const TYPE_JSONLD = 'application/ld+json';
export const axiosInstance = axios.create({});
axiosInstance.interceptors.request.use((request) => {
  request.headers['Content-Type'] = TYPE_JSONLD;

  return request;
});
axiosInstance.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (401 === error.response?.status && !refreshing) {
      try {
        await store.dispatch('auth/REFRESH_TOKEN');

        return axiosInstance.request(error.config);
      } catch (e) {
      }
    }
    logout();

    return Promise.reject(error);
  },
);
