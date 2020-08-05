/* eslint-disable no-undef */
import VueRouter from 'vue-router'

let routes = [
  {
    path: '/home',
    component: require('./views/dashboard').default,
    name: 'Home'
  },
  {
    path: '/user',
    component: require('./views/users').default,
    name: 'User'
  },
  {
    path: '/dompet',
    component: require('./views/dompet').default,
    name: 'Dompet'
  },
  {
    path: '/dompet/:id/',
    component: require('./views/detail-dompet').default,
    name: 'Detail Dompet'
  },
  {
    path: '/kategori',
    component: require('./views/kategori').default,
    name: 'Kategori'
  },
  {
    path: '/kategori/:id',
    component: require('./views/detail-kategori').default,
    name: 'Detail Kategori'
  },
  {
    path: '/transaksi',
    component: require('./views/transaksi').default,
    name: 'Transaksi'
  },
  {
    path: '/aktivitas',
    component: require('./views/aktivitas').default,
    name: 'Aktivitas'
  },
  {
    path: '/aktivitas/:id',
    component: require('./views/detail-aktivitas').default,
    name: 'Detail Aktivitas'
  },
  {
    path: '/laporan',
    component: require('./views/laporan').default,
    name: 'Laporan'
  }
]

export default new VueRouter({
  base: '/admin/',
  mode: 'history',
  routes,
  linkActiveClass: 'active'
})
