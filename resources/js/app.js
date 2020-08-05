require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import Form from './utilities/Form'
import router from './routes'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Multiselect from 'vue-multiselect'

window.Vue = Vue
window.Form = Form

Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.component('multiselect', Multiselect)

Vue.filter('rupiah', function (value) {
  if (isNaN(value)) return
  else if (value === 0) return value
  const formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
  })
  return formatter.format(value)
})

new Vue({
  el: '#app',
  router
})
