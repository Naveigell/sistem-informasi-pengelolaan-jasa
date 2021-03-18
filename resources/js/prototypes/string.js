String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

String.prototype.cutIfGreaterThan = function (number) {
    if (this.length > number) {
        return this.slice(0, number);
    }
    return this;
}

export default String;
