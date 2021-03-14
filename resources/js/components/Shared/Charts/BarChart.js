import VueChart from 'vue-chartjs';

export default {
    extends: VueChart.Bar,
    props: ['options', 'data'],
    mounted () {
        const option = this.options || {
            responsive: true,
            maintainAspectRatio: false,
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
                        beginAtZero: true
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
