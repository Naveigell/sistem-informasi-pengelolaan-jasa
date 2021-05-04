let choosesSentences = 0;
let max = 0;

const SENTENCES = [
    ["rb", "ribu"],
    ["jt", "juta"],
];

class CurrencySentences {
    constructor() {
        this.FULL_SENTENCES = 8123;
        this.HALF_SENTENCES = 23412;

        choosesSentences = this.HALF_SENTENCES;
    }

    setSentencesOption(value){
        choosesSentences = value;
    }

    parse(value){
        let sentences = SENTENCES[0];
        if (max > 6) {
            sentences = SENTENCES[1];
        }

        let cur = sentences[0];
        if (choosesSentences === this.FULL_SENTENCES) {
            cur = sentences[1];
        }

        value = value / (10 ** (max - 1));

        return `${value} ${cur}`;
    }

    parseMax(value) {
        let index = 0;
        let val = value;

        while (val > 0) {
            val = val / 10;
            val = parseInt(val);
            index++;
        }

        max = index;

        return max;
    }
}

const currency = {
    indonesian: function (value) {
        let val = (value/1).toFixed(0).replace('.', ',');
        return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    },
    sentences: new CurrencySentences()
};

export default currency;
