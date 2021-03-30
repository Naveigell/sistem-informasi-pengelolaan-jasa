import Vue from "vue";
import VueRouter from "vue-router";

import Dashboard from "../components/Pages/Main/Dashboard/Body";

import SparepartIndex from "../components/Pages/Main/Sparepart/Index/Body";
import SparepartUpdate from "../components/Pages/Main/Sparepart/Update/Body";
import SparepartInsert from "../components/Pages/Main/Sparepart/Insert/Body";

import UserIndex from "../components/Pages/Main/User/Index/Body";

import TechnicianIndex from "../components/Pages/Main/Technician/Index/Body";
import TechnicianUpdate from "../components/Pages/Main/Technician/Update/Body";

import Biodata from "../components/Pages/Main/Biodata/Body";

import OrderIndex from "../components/Pages/Main/Orders/Index/Body";
import OrderInsert from "../components/Pages/Main/Orders/Insert/Body";

import ServiceIndex from "../components/Pages/Main/Service/Index/Body";

import Errors404 from "../components/Errors/Errors404";

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/sparepart',
            name: 'sparepart',
            component: SparepartIndex,
        },
        {
            path: '/sparepart/add',
            name: 'sparepart.insert',
            component: SparepartInsert,
        },
        {
            path: '/sparepart/:id',
            name: 'sparepart.update',
            component: SparepartUpdate,
        },
        {
            path: '/user',
            name: 'user',
            component: UserIndex,
        },
        {
            path: '/technician',
            name: 'technician',
            component: TechnicianIndex,
        },
        {
            path: '/technician/:username',
            name: 'technician.update',
            component: TechnicianUpdate,
        },
        {
            path: '/account/biodata',
            name: 'biodata',
            component: Biodata,
        },
        {
            path: '/service',
            name: 'service',
            component: ServiceIndex,
        },
        {
            path: '/orders',
            name: 'orders',
            component: OrderIndex,
        },
        {
            path: '/orders/add',
            name: 'orders.add',
            component: OrderInsert
        },
        {
            path: '*',
            name: 'notfound',
            component: Errors404
        }
    ],
});
