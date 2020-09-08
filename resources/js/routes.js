/* eslint-disable no-undef */
import VueRouter from 'vue-router'
import Dashboard from './views/dashboard.vue'
import Pegawai from './views/pegawai.vue'
import Dompet from './views/dompet.vue'
import Kategori from './views/kategori.vue'
import Transaksi from './views/transaksi.vue'
import Laporan from './views/laporan.vue'
import Aktivitas from './views/aktivitas.vue'
import DetailDompet from './views/detail-dompet.vue'
import DetailAktivitas from './views/detail-aktivitas.vue'
import DetailKategori from './views/detail-kategori.vue'

let routes = [
  {
    path: '/home',
    component: Dashboard,
    name: 'Home'
  },
  {
    path: '/pegawai',
    component: Pegawai,
    name: 'Pegawai'
  },
  {
    path: '/dompet',
    component: Dompet,
    name: 'Dompet'
  },
  {
    path: '/dompet/:id/',
    component: DetailDompet,
    name: 'Detail Dompet'
  },
  {
    path: '/kategori',
    component: Kategori,
    name: 'Kategori'
  },
  {
    path: '/kategori/:id',
    component: DetailKategori,
    name: 'Detail Kategori'
  },
  {
    path: '/transaksi',
    component: Transaksi,
    name: 'Transaksi'
  },
  {
    path: '/aktivitas',
    component: Aktivitas,
    name: 'Aktivitas'
  },
  {
    path: '/aktivitas/:id',
    component: DetailAktivitas,
    name: 'Detail Aktivitas'
  },
  {
    path: '/laporan',
    component: Laporan,
    name: 'Laporan'
  }
]

export default new VueRouter({
  base: '/admin/',
  mode: 'history',
  routes,
  linkActiveClass: 'active'
})
