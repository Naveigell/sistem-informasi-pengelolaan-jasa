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
import OrderShow from "../components/Pages/Main/Orders/Show/Body";
import OrderPrint from "../components/Pages/Main/Orders/Prints/Body";

import ServiceIndex from "../components/Pages/Main/Service/Index/Body";

import SuggestionsIndex from "../components/Pages/Main/Suggestion/Index/Body";
import SuggestionsInsert from "../components/Pages/Main/Suggestion/Insert/Body";
import SuggestionsShow from "../components/Pages/Main/Suggestion/Show/Body";

import ComplaintIndex from "../components/Pages/Main/Complaint/Index/Body";
import ComplaintShow from "../components/Pages/Main/Complaint/Show/Body";

import ReportsIndex from "../components/Pages/Main/Reports/Index/Body";

import Errors404 from "../components/Errors/Errors404";

Vue.use(VueRouter);

export const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'dashboard',
            component: Dashboard,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/sparepart',
            name: 'sparepart',
            component: SparepartIndex,
            meta: {
                roles: ["admin", "teknisi"]
            }
        },
        {
            path: '/sparepart/add',
            name: 'sparepart.insert',
            component: SparepartInsert,
            meta: {
                roles: ["admin"]
            }
        },
        {
            path: '/sparepart/:id',
            name: 'sparepart.update',
            component: SparepartUpdate,
            meta: {
                roles: ["admin", "teknisi"]
            }
        },
        {
            path: '/user',
            name: 'user',
            component: UserIndex,
            meta: {
                roles: ["admin"]
            }
        },
        {
            path: '/technician',
            name: 'technician',
            component: TechnicianIndex,
            meta: {
                roles: ["admin", "user"]
            }
        },
        {
            path: '/technician/:username',
            name: 'technician.update',
            component: TechnicianUpdate,
            meta: {
                roles: ["admin"]
            }
        },
        {
            path: '/account/biodata',
            name: 'biodata',
            component: Biodata,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/service',
            name: 'service',
            component: ServiceIndex,
            meta: {
                roles: ["admin"]
            }
        },
        {
            path: '/orders',
            name: 'orders',
            component: OrderIndex,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/orders/add',
            name: 'orders.add',
            component: OrderInsert,
            meta: {
                roles: ["admin"]
            }
        },
        {
            path: '/orders/:unique_id',
            name: 'orders.show',
            component: OrderShow,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/orders/:unique_id/print',
            name: 'orders.print',
            component: OrderPrint,
            meta: {
                fullscreen: true,
                roles: ["admin"]
            }
        },
        {
            path: '/suggestions',
            name: 'suggestions',
            component: SuggestionsIndex,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/suggestions/add',
            name: 'suggestions.add',
            component: SuggestionsInsert,
            meta: {
                roles: ["user"]
            }
        },
        {
            path: '/suggestions/:id',
            name: 'suggestions.show',
            component: SuggestionsShow,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/complaints',
            name: 'complaints',
            component: ComplaintIndex,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/complaints/:id',
            name: 'complaints.show',
            component: ComplaintShow,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        },
        {
            path: '/reports',
            name: 'reports',
            component: ReportsIndex,
            meta: {
                roles: ["admin"]
            }
        },
        {
            path: '*',
            name: 'notfound',
            component: Errors404,
            meta: {
                roles: ["admin", "teknisi", "user"]
            }
        }
    ],
});
