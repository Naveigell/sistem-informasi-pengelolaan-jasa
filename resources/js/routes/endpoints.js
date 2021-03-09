const endpoints = {
    auth: {
        login: "/auth/login",
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
    }
}

module.exports = endpoints;
