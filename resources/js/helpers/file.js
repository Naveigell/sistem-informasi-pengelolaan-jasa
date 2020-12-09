const random = function (length) {
    const avoid = [
        58, 59, 60, 61, 62, 63, 64,
        91, 92, 93, 94, 95, 96
    ];

    let string = "";
    for (let i = 0; i < length; i++) {
        let rand = Math.floor(48 + Math.random() * 74);

        while (avoid.includes(rand))
            rand = Math.floor(48 + Math.random() * 74);

        string += String.fromCharCode(rand);
    }

    return string;
};

const file = {
    urlToFile: async function (url, filename) {
        const name = filename || random(64);
        const response = await fetch(url);
        const blob = response.blob();
        const file = await blob.then(function (response) {
            return response;
        });

        return new File([file], name + "." + file.type.split("/")[1], {type: file.type});
    }
};

export default file;
