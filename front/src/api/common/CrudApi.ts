import { axiosInstance } from '@/api/axios';
import { IApiItem, ICrudApi } from '@/interfaces';
import { BaseApi } from './BaseApi';

export class CrudApi extends BaseApi implements ICrudApi<IApiItem> {
  fetchAll() {
    return axiosInstance.get(this.endpoint);
  }

  find(iri: string) {
    return axiosInstance.get(iri);
  }

  create(item: IApiItem) {
    return axiosInstance.post(this.endpoint, item);
  }

  update(item: IApiItem) {
    return axiosInstance.put(item['@id'], item);
  }

  createOrUpdate(item: IApiItem) {
    if (item['@id']) {
      return this.update(item);
    }

    return this.create(item);
  }

  delete(iri: string) {
    return axiosInstance.delete(iri);
  }
}
