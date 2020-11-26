
const api = {
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
        search: "/spareparts/search"
    }
}

module.exports = api;
