/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import axios from "axios";

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/App.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/App.vue').default);
import App from './components/App.vue';
import Endpoints from './routes/endpoints';
import Math from './helpers/math';
import Http from './helpers/http';

import Header from "./components/Includes/Header";
import Sidebar from "./components/Includes/Sidebar";
import Container from "./components/Includes/Container";
import Layout from "./components/Layouts/Layout";

Vue.component('app-header', Header);
Vue.component('app-sidebar', Sidebar);
Vue.component('app-container', Container);
Vue.component('app-layout', Layout);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use({
    install(Vue) {

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
    }
});

const app = new Vue({
    render: h => h(App)
}).$mount("#app");
