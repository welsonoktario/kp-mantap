require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import Form from './utilities/Form';
import router from './routes';

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

window.Vue = Vue;
window.Form = Form;

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(IconsPlugin);

new Vue({
  el: '#app',
  router,
});
