import { IUserPayload } from '@/interfaces';

export interface IAuthRequest {
  email: string;
  password: string;
}

export interface IAuthResponse {
  permissions: string[];
  refresh_token: string;
  user: IUserPayload;
}

export interface INewPasswordRequest {
  email: string;
  nir: string;
}

export interface IPasswordGenerationRequest {
  password: string;
  password2: string;
}
