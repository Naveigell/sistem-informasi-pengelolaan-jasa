
class http {
    constructor(http) {
        this.responseCallback = null;
        this.errorCallback = null;
        this.http = http;
    }

    onResponse(callback) {
        this.responseCallback = callback;
        return this;
    }

    onError(callback) {
        this.errorCallback = callback;
        return this;
    }

    async post(url, data = {}, headers = {}) {
        const self = this;

        await self.http.post(url, data, headers).then(function (response){
            if (self.responseCallback == null) return;

            self.responseCallback(response);
        }).catch(function(error) {
            if (self.errorCallback == null) return;

            self.errorCallback(error);
        });
    }

    async get(url, data = {}, headers = {}) {
        const self = this;

        await self.http.get(url, data, headers).then(function (response){
            if (self.responseCallback == null) return;

            self.responseCallback(response);
        }).catch(function(error) {
            if (self.errorCallback == null) return;

            self.errorCallback(error);
        });
    }
}

export default http;
