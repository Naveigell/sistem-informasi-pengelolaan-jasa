function uuidv4() {
    return 'xxxxxxxxxxxx4xxxyxxxxxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
        const r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });
}

const exporter = {
    generate(blob, type, extension, filename){
        const data = new Blob([blob], { type });

        if (window.navigator && window.navigator.msSaveOrOpenBlob) {
            window.navigator.msSaveOrOpenBlob(data);
            return;
        }

        const href = window.URL.createObjectURL(data);
        const link = document.createElement('a');
        link.href = href;
        link.download = filename || uuidv4() + `.${extension}`;
        link.click();

        setTimeout(function () {
            window.URL.revokeObjectURL(href);
        }, 100)
    }
}

export default exporter;
