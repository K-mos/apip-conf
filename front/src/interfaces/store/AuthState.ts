import { IUserPayload } from "../security";

export interface IAuthState {
  permissions: string[];
  user: IUserPayload|null;
}
