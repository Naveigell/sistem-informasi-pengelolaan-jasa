/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuex from "vuex";
import VueRouter from "vue-router";

import "./prototypes/string";
import "./prototypes/array";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/LoginAndDashboard.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Header from "./components/Includes/Header";
import Sidebar from "./components/Includes/Sidebar";
import Layout from "./components/Layouts/Layout";

// includes
Vue.component('app-header', Header);
Vue.component('app-sidebar', Sidebar);

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
import QueryString from "./helpers/query_string";
import Exporter from "./helpers/exporter";
import Role from "./helpers/role";

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
        Vue.prototype.$querystring = QueryString;
        Vue.prototype.$exporter = Exporter;
        Vue.prototype.$role = Role;
    }
});

import { store } from "./stores/store";
import { router } from "./routes/router";

Vue.config.productionTip = false;

Vue.use(Vuex);
Vue.use(VueRouter);

Vue.mixin({
    methods: {
        back(msg){
            this.$router.back();
        },
        moveTo(path) {
            this.$router.push({
                path
            });
        }
    }
});

const app = new Vue({
    // render: h => h(LoginAndDashboard),
    store,
    router,
    components: { Layout },
    async mounted() {
        await this.$store.commit('retrieveUserData');
    }
}).$mount("#app");

