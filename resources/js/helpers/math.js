const math = {
    status: function (error) {
        return Math.floor(error.response.status / 100);
    },
    clamp(number, min, max){
        return Math.min(Math.max(number, min), max);
    }
};

module.exports = math;
