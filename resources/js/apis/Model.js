import axios, { AxiosResponse } from "axios";
import pluralize from "pluralize";
import { cloneDeep } from "lodash";

export class Model {
  /**
   * @type {Object}
   */
  rules = {};

  /**
   * @type {Object}
   */
  attrs = {};

  /**
   *
   * @type {string}
   */
  #prefix = '';

  /**
   * @type {String}
   */
  #origin = process.env.MIX_APP_URL;

  /**
   * @type {number}
   */
  static MODE_CREATE = 1;

  /**
   * @type {number}
   */
  static MODE_UPDATE = 2;

  /**
   * @type {number}
   */
  static MODE_DELETE = 0;

  /**
   * Model Constructor
   *
   * @param {Object} attrs
   */
  constructor(attrs) {
    this.attrs = cloneDeep(attrs);
    // this.#path = path;
    Object.keys(this.attrs).forEach(key => {
      Object.defineProperty(this, key, {
        get() {
          return this.get(key);
        },
        set(v) {
          this.set({[key]: v});
        }
      });
    });
  }

  /**
   *
   * @param {String} key
   * @returns {*}
   */
  get(key) {
    return this.attrs[key];
  }

  /**
   *
   * @param {Object} attrs
   */
  set(attrs) {
    this.attrs = Object.assign({}, this.attrs, attrs);
  }

  /**
   *
   * @returns {Object}
   */
  get all() {
    return this.attrs;
  }

  get uri() {
    return pluralize.plural(this.constructor.name.toLowerCase());
  }

  /**
   * Get URI prefix
   *
   * @returns {string}
   */
  get prefix() {
    return this.#prefix;
  }

  /**
   * Set URI prefix
   * @param {String} prefix
   */
  set prefix(prefix) {
    this.#prefix = prefix;
  }

  /**
   *
   * @param {Object} config
   * @returns {Promise<AxiosResponse<*>>}
   */
  create(config = {}) {
    return this.#request('create', config);
  }

  /**
   *
   * @param {Object} config
   * @returns {Promise<AxiosResponse<*>>}
   */
  update(config = {}) {
    return this.#request('update', config);
  }

  /**
   *
   * @param {Object} config
   * @returns {Promise<AxiosResponse<*>>}
   */
  destroy(config = {}) {
    return this.#request('destroy', config);
  }

  /**
   * Get request full url
   *
   * @param {string} name
   * @returns {{url: String, method: String}}
   */
  #action(name) {
    switch (name) {
      case 'create':
        return {
          method: 'post',
          url: `${this.#origin}/` + (this.prefix ? `${this.prefix}/` : '') + `${this.uri}`,
        };
      case 'update':
        return {
          method: 'put',
          url: `${this.#origin}/` + (this.prefix ? `${this.prefix}/` : '') + `${this.uri}/${this.get('id')}`,
        };
      case 'destroy':
        return {
          method: 'delete',
          url: `${this.#origin}/` + (this.prefix ? `${this.prefix}/` : '') + `${this.uri}/${this.get('id')}`,
        };
      default :
        throw Error('Wrong action name provided!');
    }
  }

  /**
   *
   * @param actionName
   * @param config
   * @returns {Promise<AxiosResponse<any>>}
   */
  #request(actionName, config) {
    const action = this.#action(actionName);

    return axios.request({
      url: action.url,
      method: action.method,
      baseURL: this.#origin,
      headers: config.headers || {},
      params: config.params || {},
      data: this.all
    });
  }
}
