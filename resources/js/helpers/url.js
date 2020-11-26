const url = {
    /**
     *
     * @param u u -> url
     * @param d d -> data
     * @param h
     */
    generateUrl: function (u, d, h){
        const splitSlash = function(...params){
            this.url = u.split("/");
            let index = 0;

            this.params = this.url.filter(function(item){
                return item[0] === ":";
            });

            if (params.length === this.params.length) {

                for (let i = 0; i < this.url.length; i++) {
                    if (this.url[i][0] === ":") {
                        this.url[i] = params[index];
                        ++index;
                    }
                }

                return this.url.join("/");
            }
            else {
                throw Error("Passed length of arguments are less than 0 or more than params");
            }
        };

        this.post = function(...params) {
            return splitSlash(...params);
        }

        return this.post;
    }
};

module.exports = url;
