// const Client = axios.create({
//   baseURL: "/clients"
// });

import { Model } from "./Model";

export class Client extends Model {
  static state = {
    id: null,
    name: ""
  };

  rules = {
    name: {
      required: true,
      string: true,
      max: 255,
      min: 3
    }
  }

  constructor(attrs = {}) {
    super(Object.assign({}, Client.state, attrs));
  }
}
