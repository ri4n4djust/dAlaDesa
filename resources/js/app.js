/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
import VueNumericInput from 'vue-numeric-input';

Vue.use(VueNumericInput);

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';

import App from './app.vue';
Vue.use(VueAxios, axios);
//axios.defaults.baseURL = 'http://35.184.16.20/api/';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

Vue.use(VueSweetalert2);

import VueSession from 'vue-session';
Vue.use(VueSession);

import vmodal from 'vue-js-modal';
    Vue.use(vmodal);

import Vue from 'vue';
import VueImg from 'v-img';
    Vue.use(VueImg);
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserSecret } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faUserSecret)

Vue.component('font-awesome-icon', FontAwesomeIcon)

// import printJS from 'print-js'
// //Vue.use(printJS);

// import VueHtmlToPaper from 'vue-html-to-paper';
// const options = {
//   name: '_blank',
//   specs: [
//     'fullscreen=yes',
//     'titlebar=yes',
//     'scrollbars=yes'
//   ],
//   styles: [
//     'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
//     'https://unpkg.com/kidlat-css/css/kidlat.css'
//   ]
// }
// Vue.use(VueHtmlToPaper, options);


import IndexComponent from './components/posts/Index.vue';
import CreateComponent from './components/posts/Create.vue';
import EditComponent from './components/posts/Edit.vue';
import mentahComponent from './components/posts/barangMentah.vue';

import IndexSupComponent from './components/supplier/Index.vue';
import CreateSupComponent from './components/supplier/Create.vue';
import EditSupComponent from './components/supplier/Edit.vue';

import IndexCustComponent from './components/customer/Index.vue';
import CreateCustComponent from './components/customer/Create.vue';
import EditCustComponent from './components/customer/Edit.vue';

import IndexKatComponent from './components/kategori/Index.vue';
import CreateKatComponent from './components/kategori/Create.vue';
import EditKatComponent from './components/kategori/Edit.vue';

import IndexMejaComponent from './components/meja/Index.vue';
import CreateMejaComponent from './components/meja/Create.vue';
import EditMejaComponent from './components/meja/Edit.vue';
import DetailMejaComponent from './components/meja/Detail.vue';

import IndexMenuComponent from './components/menu/Index.vue';
import CreateMenuComponent from './components/menu/Create.vue';
import EditMenuComponent from './components/menu/Edit.vue';

import IndexUserComponent from './components/user/Index.vue';
import CreateUserComponent from './components/user/Create.vue';
import EditUserComponent from './components/user/Edit.vue';

import CreatePembelian from './components/PembelianCreate.vue';
import liveorder from './components/LiveOrder.vue';

import Tesprint from './components/TesPrint.vue';

import homeComponent from './components/Home.vue';
import Dashboard from './components/Dashboard.vue';
import StatusLogin from './components/Status.vue';
Vue.component('status-login', StatusLogin);


import LaporanPenjualanComponent from './components/laporan/laporanPenjualan.vue';
import LaporanPenjualanBarangComponent from './components/laporan/laporanPenjualanBarang.vue';
import LaporanPenjualanBulanan from './components/laporan/laporanPenjualanBulanan.vue';
import LaporanPembelianComponent from './components/laporan/laporanPembelian.vue';
import LaporanPembelianBulanan from './components/laporan/laporanPembelianBulanan.vue';
import StokOpnameComponent from './components/laporan/laporanStokOpname.vue';

import ViewStokOpnameComponent from './components/stokOpname/StokOpname.vue';
import InputStokOpnameComponent from './components/stokOpname/StokOpnameCreate.vue';

import InventoriComponent from './components/stokInventori/StokInventori.vue';
import DetailInventoriComponent from './components/stokInventori/DetailInventori.vue';
import InputInventoriComponent from './components/stokInventori/StokInventoriCreate.vue';

import VueCurrencyFilter from 'vue-currency-filter'
Vue.use(VueCurrencyFilter,
    {
      symbol : 'Rp.',
      thousandsSeparator: '.',
      fractionCount: 0,
      fractionSeparator: ',',
      symbolPosition: 'front',
      symbolSpacing: true
    })

const routes = [
    {
        name: 'posts',
        path: '/barang',
        component: IndexComponent
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'barangmentah',
        path: '/barangmentah',
        component: mentahComponent
    },
    {
        name: 'create',
        path: '/barang/create',
        component: CreateComponent
    },
    {
        name: 'edit',
        path: '/barang/edit/:id',
        component: EditComponent
    },
    //supplier
    {
        name: 'supplier',
        path: '/supplier',
        component: IndexSupComponent
    },
    {
        name: 'createSupplier',
        path: '/supplier/create',
        component: CreateSupComponent
    },
    {
        name: 'editSupplier',
        path: '/supplier/edit/:id',
        component: EditSupComponent
    },
    //pelanggan
    {
        name: 'pelanggan',
        path: '/pelanggan',
        component: IndexCustComponent
    },
    {
        name: 'createPelanggan',
        path: '/pelanggan/create',
        component: CreateCustComponent
    },
    {
        name: 'editPelanggan',
        path: '/pelanggan/edit/:id',
        component: EditCustComponent
    },
    //Kategori
    {
        name: 'kategori',
        path: '/kategori',
        component: IndexKatComponent
    },
    {
        name: 'createKategori',
        path: '/kategori/create',
        component: CreateKatComponent
    },
    {
        name: 'editKategori',
        path: '/kategori/edit/:id',
        component: EditKatComponent
    },
    //meja
    {
        name: 'meja',
        path: '/meja',
        component: IndexMejaComponent
    },
    {
        name: 'createMeja',
        path: '/meja/create',
        component: CreateMejaComponent
    },
    {
        name: 'editMeja',
        path: '/meja/edit/:id',
        component: EditMejaComponent
    },
    {
        name: 'detailMeja',
        path: '/meja/detail/:id',
        component: DetailMejaComponent
    },
    //menu
    {
        name: 'menu',
        path: '/menu',
        component: IndexMenuComponent
    },
    {
        name: 'createMenu',
        path: '/menu/create',
        component: CreateMenuComponent
    },
    {
        name: 'editMenu',
        path: '/menu/edit/:id',
        component: EditMenuComponent
    },
    //=============User
    {
        name: 'user',
        path: '/user',
        component: IndexUserComponent
    },
    {
        name: 'createUser',
        path: '/user/create',
        component: CreateUserComponent
    },
    {
        name: 'editUser',
        path: '/user/edit/:id',
        component: EditUserComponent
    },
    //=======Pembelian
    {
        name: 'pembelian',
        path: '/pembelian',
        component: CreatePembelian
    },
    //=======Live Order
    {
        name: 'liveorder',
        path: '/liveorder',
        component: liveorder
    },

    {
        name: 'tesprint',
        path: '/tesprint',
        component: Tesprint
    },

    //=======Laporan
    {
        name: 'laporanpenjualan',
        path: '/laporanpenjualan',
        component: LaporanPenjualanComponent
    },
    {
        name: 'laporanpenjualanbarang',
        path: '/laporanpenjualanbarang',
        component: LaporanPenjualanBarangComponent
    },
    {
        name: 'laporanpenjualanbulanan',
        path: '/laporanpenjualanbulanan',
        component: LaporanPenjualanBulanan
    },
    {
        name: 'laporanpembelian',
        path: '/laporanpembelian',
        component: LaporanPembelianComponent
    },
    {
        name: 'laporanpembelianbulanan',
        path: '/laporanpembelianbulanan',
        component: LaporanPembelianBulanan
    },
    {
        name: 'laporanstokopname',
        path: '/laporanstokopname',
        component: StokOpnameComponent
    },

    //=========Stok Opname
    {
        name: 'stokopname',
        path: '/stokopname',
        component: ViewStokOpnameComponent
    },
    {
        name: 'stokopnamecreate',
        path: '/stokopnamecreate',
        component: InputStokOpnameComponent
    },
    {
        name: 'stokinventori',
        path: '/stokinventori',
        component: InventoriComponent
    },
    {
        name: 'detailInventori',
        path: '/detailInventori/:id',
        component: DetailInventoriComponent
    },
    {
        name: 'stokinventoricreate',
        path: '/stokinventoricreate',
        component: InputInventoriComponent
    },
    //=========Home
    {
        name: 'home',
        path: '/',
        component: homeComponent
    }
];



const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');

