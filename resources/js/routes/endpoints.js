const endpoints = {
    dashboard: {
        total: "/dashboard/total",
        graph: "/dashboard/graph"
    },
    auth: {
        login: "/auth/login",
        logout: "/auth/logout",
        check: "/auth/check",
        data: "/auth/session/data",
        change_password: "/auth/change-password",
    },
    biodata: {
        data: "/biodata",
        image: "/biodata/image",
        graph: "/biodata/graph"
    },
    sparepart: {
        data: "/spareparts",
        search: "/spareparts/search",
        insert: "/spareparts",
        get: "/spareparts/retrieve",
        put: "/spareparts",
        delete: "/spareparts"
    },
    service: {
        data: "/service",
        activation: "/service/activate",
        insert: "/service",
        delete: "/service",
        update: "/service"
    },
    admins: {
        data: "/admins",
        search: "/admins/search",
        insert: "/admins",
        delete: "/admins",
        retrieve: "/admins/username/:username",
    },
    technicians: {
        data: "/technicians",
        search: "/technicians/search",
        insert: "/technicians",
        delete: "/technicians",
        update: "/technicians",
        retrieve: "/technicians/username",
        reset_password: "/technicians/reset-password",
        graph: "/technicians/:id/graph"
    },
    users: {
        data: "/users",
        search: "/users/search",
        search_email: "/users/search/email",
        insert: "/users",
        delete: "/users",
        retrieve: "/users/username/:username",
    },
    orders: {
        last: "/orders/take/:number/last",
        total: "/orders/total",
        data: "/orders",
        search: "/orders/search",
        search_sparepart: "/orders/search/spareparts",
        save_sparepart: "/orders/search/spareparts",
        insert: "/orders",
        retrieve: "/orders/retrieve/:id",
        delete: "/orders",
        take: "/orders/take",
        update_status: "/orders/status",
        complaint: "/orders/complaint",
        print: "/orders/:unique_id/print"
    },
    suggestions: {
        data: "/suggestions/:last_id",
        insert: "/suggestions",
        retrieve: "/suggestions/retrieve/:id",
        delete: "/suggestions",
        reply: "/suggestions/:id/reply"
    },
    complaints: {
        data: "/complaints",
        retrieve: "/complaints/retrieve/:id",
        do_complaint: "/complaints/do-complaint/:id",
        do_user_accept: "/complaints/do-user-accept/:id",
        do_admin_accept: "/complaints/do-admin-accept/:id"
    },
    history: {
        data: "/history"
    },
    exports: {
        finance: {
            excel: "/reports/:name/:type"
        }
    }
}

module.exports = endpoints;
