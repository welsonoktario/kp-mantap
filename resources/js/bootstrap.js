import axios from 'axios';
window._ = require('lodash');

try {
  window.Popper = require('popper.js').default;
  window.$ = window.jQuery = require('jquery');

  require('bootstrap');
  require('admin-lte');
} catch (e) {
  console.log(e);
}

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
