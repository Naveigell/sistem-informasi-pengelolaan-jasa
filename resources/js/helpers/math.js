const math = {
    status: function (error) {
        return Math.floor(error.response.status / 100);
    }
};

module.exports = math;
