import { Model } from "./Model";

export class Project extends Model {
  rules = {
    name: {
      required: true,
      string: true,
      max: 255,
      min: 3
    }
  };

  static state = {
    id: null,
    name: ""
  }

  constructor() {
    super(Object.assign({}, Project.state));
  }
}
