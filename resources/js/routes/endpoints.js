const endpoints = {
    dashboard: {
        total: "/dashboard/total"
    },
    auth: {
        login: "/auth/login",
        logout: "/auth/logout",
        check: "/auth/check",
        data: "/auth/session/data"
    },
    biodata: {
        data: "/biodata",
        image: "/biodata/image"
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
        update_status: "/orders/status"
    },
    suggestions: {
        data: "/suggestions/:last_id",
        insert: "/suggestions",
        retrieve: "/suggestions/retrieve/:id"
    }
}

module.exports = endpoints;
