import { ref } from 'vue';
import { CrudApi } from '@/api/common/CrudApi';

export const useItemsFetch = <T>(endpoint: string) => {
  const api = new CrudApi(endpoint);
  const items = ref<T[]>([]);
  const total = ref(0);
  const loading = ref(false);

  const fetchAll = async () => {
    loading.value = true;
    items.value = [];
    total.value = 0;

    const res = await api.fetchAll();
    items.value = res.data['hydra:member'];
    total.value = res.data['hydra:totalItems'];
    loading.value = false;
  }

  return {
    items,
    total,
    loading,
    fetchAll,
  }
}
