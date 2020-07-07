/* eslint-disable no-undef */
import VueRouter from 'vue-router';

let routes = [
  {
    path: '/home',
    component: require('./views/dashboard').default,
    name: 'Home',
  },
  {
    path: '/user',
    component: require('./views/users').default,
    name: 'User',
  },
  {
    path: '/transaksi',
    component: require('./views/transaksi').default,
    name: 'Transaksi',
  },
  {
    path: '/laporan',
    component: require('./views/laporan').default,
    name: 'Laporan',
  },
];

export default new VueRouter({
  base: '/admin/',
  mode: 'history',
  routes,
  linkActiveClass: 'active',
});
