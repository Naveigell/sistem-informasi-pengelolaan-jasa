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
    technicians: {
        data: "/technicians",
        search: "/technicians/search",
        insert: "/technicians",
        delete: "/technicians",
        update: "/technicians",
        retrieve: "/technicians/username",
        reset_password: "/technicians/reset-password",
    },
    users: {
        data: "/users",
        search: "/users/search",
        search_email: "/users/search/email",
        insert: "/users",
        delete: "/users"
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
        do_accept: "/complaints/do-accept/:id"
    },
    exports: {
        finance: {
            excel: "/reports/:name/:type"
        }
    }
}

module.exports = endpoints;
