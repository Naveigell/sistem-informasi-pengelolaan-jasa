/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

window.Vue = require('vue');

import Vuex from "vuex";

import String from "./prototypes/string";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/LoginAndDashboard.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/LoginAndDashboard.vue').default);
import LoginAndDashboard from './components/Templates/LoginAndDashboard.vue';
import Biodata from "./components/Templates/Biodata";
import SparepartIndex from "./components/Templates/Sparepart/Index";
import SparepartInsert from "./components/Templates/Sparepart/Insert";
import SparepartUpdate from "./components/Templates/Sparepart/Update";
import ServiceIndex from "./components/Templates/Service/Index";
import TechnicianIndex from "./components/Templates/Technician/Index";
import TechnicianUpdate from "./components/Templates/Technician/Update";
import UserIndex from "./components/Templates/User/Index";

import Header from "./components/Includes/Header";
import Sidebar from "./components/Includes/Sidebar";
import Container from "./components/Includes/Container";
import Layout from "./components/Layouts/Layout";

import FullLoading from "./components/Loaders/FullLoading";

import FullOverlay from "./components/Overlays/FullOverlay";

import Test from "./components/Test";

Vue.component('test', Test);

// includes
Vue.component('app-header', Header);
Vue.component('app-sidebar', Sidebar);
Vue.component('app-container', Container);
Vue.component('app-layout', Layout);

// templates
Vue.component('login-and-dashboard-component', LoginAndDashboard);
Vue.component('biodata', Biodata);
Vue.component('sparepart-index', SparepartIndex);
Vue.component('sparepart-insert', SparepartInsert);
Vue.component('sparepart-update', SparepartUpdate);
Vue.component('service-index', ServiceIndex);
Vue.component('technician-index', TechnicianIndex);
Vue.component('technician-update', TechnicianUpdate);
Vue.component('user-index', UserIndex);

// loader
Vue.component('full-loading', FullLoading);

// overlays
Vue.component('full-overlay', FullOverlay);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Math from "./helpers/math";
import Http from "./helpers/http";
import Urls from "./helpers/url";
import Currency from "./helpers/currency";
import Image from "./helpers/file";
import Color from "./helpers/color";
import Colors from "./colors/color";

import axios from "axios";
import Endpoints from "./routes/endpoints";

Vue.use({
    async install(Vue) {
        const axiosInstance = axios.create({
            baseURL: "http://localhost:8000/api/v1/",
            headers: {
                'Content-Type': 'application/json'
            }
        });

        Vue.prototype.$api = axiosInstance;

        Vue.prototype.$endpoints = Endpoints;
        Vue.prototype.$math = Math;
        Vue.prototype.$basepath = "http://localhost:8000/";
        Vue.prototype.$http = new Http(axiosInstance);
        Vue.prototype.$url = Urls;
        Vue.prototype.$currency = Currency;
        Vue.prototype.$image = Image;
        Vue.prototype.$color = Color;
        Vue.prototype.$colors = Colors;
    }
});

import { store } from "./stores/store";

Vue.config.productionTip = false;

Vue.use(Vuex);

const app = new Vue({
    // render: h => h(LoginAndDashboard),
    store,
    async mounted() {
        await this.$store.commit('retrieveUserData');
    }
}).$mount("#app");

