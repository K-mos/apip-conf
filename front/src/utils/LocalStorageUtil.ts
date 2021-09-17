export const REFRESH_TOKEN_KEY = 'refresh_token';

export const getRefreshToken = (): string|null => localStorage.getItem(REFRESH_TOKEN_KEY) || null;
export const setRefreshToken = (token: string|null) => token ? localStorage.setItem(REFRESH_TOKEN_KEY, token) : localStorage.removeItem(REFRESH_TOKEN_KEY);
export const logout = () => {
  localStorage.removeItem(REFRESH_TOKEN_KEY);
  localStorage.clear();
  location.reload();
};
