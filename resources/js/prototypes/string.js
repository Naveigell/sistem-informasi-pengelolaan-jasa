String.prototype.capitalize = function () {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

String.random = function (number) {

    let str = "";

    for (let i = 0; i < number; i++) {
        str += String.fromCharCode(65 + Math.round(Math.random() * (90 - 65)));
    }

    return str;
}

String.prototype.cutIfGreaterThan = function (number) {
    if (this.length > number) {
        return this.slice(0, number);
    }
    return this;
}

export default String;
