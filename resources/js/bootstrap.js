import axios from 'axios'
window._ = require('lodash')

try {
  window.$ = window.jQuery = require('jquery')

  require('bootstrap')
  require('admin-lte')
} catch (e) {
  console.log(e)
}

window.axios = axios.create({
  // baseURL: 'http://localhost:8000/api'
  baseURL: 'http://erlanggagatum.com/api'
})

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
} else {
  console.error(
    'CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token'
  )
}
