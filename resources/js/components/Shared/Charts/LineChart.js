import VueChart from 'vue-chartjs';

export default {
    extends: VueChart.Line,
    props: ['options', 'data'],
    mounted () {
        const option = this.options || {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false
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
