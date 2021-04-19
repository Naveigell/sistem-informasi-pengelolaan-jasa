import VueChart from 'vue-chartjs';

export default {
    extends: VueChart.Line,
    props: ['options', 'data'],
    watch: {
        data: function () {
            this.renderGraph();
        }
    },
    mounted () {
        this.renderGraph();
    },
    methods: {
        renderGraph(){
            const option = this.options || {
                responsive: true,
                maintainAspectRatio: false,
                bezierCurve : false,
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            beginAtZero: true,
                            userCallback: function(label, index, labels) {
                                // when the floored value is the same as the value we have a whole number
                                if (Math.floor(label) === label) {
                                    return label;
                                }

                            },
                        }
                    }]
                }
            };

            const data = this.data || {
                labels: [],
                datasets: []
            };

            this.renderChart(data, option);
        }
    }
}
