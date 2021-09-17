import { IApiItem } from "../common";

export interface IUserPayload extends IApiItem {
  firstname: string;
  lastname: string;
}
