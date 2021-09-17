import { IAuthRequest } from '@/interfaces';

export interface IApiItem {
  '@id': string;
  [key: string]: any;
}

interface IApistringTemplateMapping {
  '@type': string;
  variable: string;
  property: string;
  required: boolean;
}

interface IApiHydraSearch {
  '@type': string;
  'hydra:template': string;
  'hydra:variableRepresentation': string;
  'hydra:mapping': IApistringTemplateMapping[];
}

export interface IApiHydraView {
  '@id': string;
  '@type': string;
  'hydra:first': string;
  'hydra:last': string;
  'hydra:next': string;
}

export interface IApiCollection<T> {
  '@context': string;
  '@id': string;
  '@type': string;
  'hydra:member': T[];
  'hydra:totalItems': number;
  'hydra:search'?: IApiHydraSearch;
  'hydra:view'?: IApiHydraView;
}

export interface IFilter {
  [key: string]: any;
}

export interface IActionParam {
  string?: string;
  filters?: IFilter;
  force?: boolean,
}

export interface ICrudApi<T> {
  fetchAll(params?: IActionParam): Promise<IApiCollection<T>>;
  find(string: string): Promise<T>;
  create(item: Partial<T>): Promise<T>;
  update(item: Partial<T>): Promise<T>;
  delete(string: string): Promise<any>;
}

export interface IAuthApi {
  login(user: IAuthRequest): Promise<any>;
  // config(): Promise<any>;
  // me(): Promise<any>;
}
