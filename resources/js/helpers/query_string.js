const queryString = {
    parse: function (arr = {}) {
        const keys = Object.keys(arr);
        const values = Object.values(arr);

        let query = "";

        for (let i = 0; i < keys.length; i++) {
            if (typeof arr[keys[i]] === "string" && arr[keys[i]].length > 0) {
                query += keys[i] + "=" + values[i];

                if (i < keys.length - 1) {
                    query += "&";
                }
            }
        }

        return "?" + query;
    }
}

module.exports = queryString;
