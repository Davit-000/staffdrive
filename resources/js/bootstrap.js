import axios from "axios";
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';
import { extend, configure } from "vee-validate";
import * as rules from "vee-validate/dist/rules";
import { messages } from "vee-validate/dist/locale/en.json";

// loads the Icon plugin
UIkit.use(Icons);

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

Object.keys(rules)
  .forEach(rule => extend(rule, {...rules[rule], message: messages[rule]}));

configure({
  classes: {invalid: 'uk-form-danger'}
});

extend('string', {
  validate: value => {
    return typeof value === 'string';
  },
  message: 'The {_field_} field must string.'
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
