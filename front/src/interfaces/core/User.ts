import { IApiItem } from "../common";

export interface IUser extends IApiItem {
  firstname: string;
  lastname: string;
  email: string;
}
