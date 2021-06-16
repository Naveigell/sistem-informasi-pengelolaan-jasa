let choosesSentences = 0;
let max = 0;

const SENTENCES = [
    ["rb", "ribu"],
    ["jt", "juta"],
    ["mlyr", "milyar"],
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
        let offset = [12, 9, 6, 3].filter(function (item) {
            return item < max;
        })[0];

        let sentences = SENTENCES[0];
        if (max > 9) {
            sentences = SENTENCES[2];
        } else if (max > 6) {
            sentences = SENTENCES[1];
        }

        let cur = sentences[0];
        if (choosesSentences === this.FULL_SENTENCES) {
            cur = sentences[1];
        }

        if (Math.floor(value) < 1000)
            return `${Math.floor(value)}`;

        value = value / (10 ** (offset));

        return `${value} ${cur}`;
    }

    parseMax(value) {
        if (value <= 0)
            return 0;

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
