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
import Api from './routes/endpoints';
import Math from './helpers/math';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use({
    install(Vue) {
        Vue.prototype.$api = axios.create({
            baseURL: "http://localhost:8000/api/v1/",
            headers: {
                'Content-Type': 'application/json'
            }
        });

        Vue.prototype.$endpoints = Api;
        Vue.prototype.$math = Math;
        Vue.prototype.$basepath = "http://localhost:8000/";
    }
});

const app = new Vue({
    render: h => h(App)
}).$mount("#app");
