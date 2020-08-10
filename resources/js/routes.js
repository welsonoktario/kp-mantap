/* eslint-disable no-undef */
import VueRouter from 'vue-router'

let routes = [
  {
    path: '/home',
    component: import('./views/dashboard'),
    name: 'Home'
  },
  {
    path: '/user',
    component: import('./views/users'),
    name: 'User'
  },
  {
    path: '/dompet',
    component: import('./views/dompet'),
    name: 'Dompet'
  },
  {
    path: '/dompet/:id/',
    component: import('./views/detail-dompet'),
    name: 'Detail Dompet'
  },
  {
    path: '/kategori',
    component: import('./views/kategori'),
    name: 'Kategori'
  },
  {
    path: '/kategori/:id',
    component: import('./views/detail-kategori'),
    name: 'Detail Kategori'
  },
  {
    path: '/transaksi',
    component: import('./views/transaksi'),
    name: 'Transaksi'
  },
  {
    path: '/aktivitas',
    component: import('./views/aktivitas'),
    name: 'Aktivitas'
  },
  {
    path: '/aktivitas/:id',
    component: import('./views/detail-aktivitas'),
    name: 'Detail Aktivitas'
  },
  {
    path: '/laporan',
    component: import('./views/laporan'),
    name: 'Laporan'
  }
]

export default new VueRouter({
  base: '/admin/',
  mode: 'history',
  routes,
  linkActiveClass: 'active'
})
