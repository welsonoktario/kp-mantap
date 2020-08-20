require('./bootstrap')

import Vue from 'vue'
import VueRouter from 'vue-router'
import router from './routes'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Multiselect from 'vue-multiselect'
import VueCurrencyInput from 'vue-currency-input'

window.Vue = Vue

const pluginOptions = {
  /* see config reference */
  globalOptions: {
    currency: 'IDR',
    locale: 'id-ID',
    'distraction-free': false,
    'allow-negative': false
  }
}

Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(VueCurrencyInput, pluginOptions)
Vue.component('multiselect', Multiselect)

Vue.filter('rupiah', function (value) {
  if (isNaN(value)) return
  else if (value === 0) return value
  const formatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 2
  })
  return formatter.format(value)
})

new Vue({
  el: '#app',
  router
})
