export class BaseApi {
  readonly endpoint: string;

  constructor(endpoint: string) {
    this.endpoint = endpoint;
  }
}
