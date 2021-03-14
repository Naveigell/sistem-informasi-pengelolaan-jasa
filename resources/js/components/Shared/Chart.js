import VueChart from 'vue-chartjs';

// Bar,
// HorizontalBar,
// Doughnut,
// Line,
// Pie,
// PolarArea,
// Radar,
// Bubble,
// Scatter,
// generateChart

export default {
    extends: VueChart.HorizontalBar,
    props: ['options', 'type'],
    mounted () {
        console.log(this.type)
        // this.$data._chart.config.type = this.type;
        // this.$data._chart.update();
        this.renderChart({
            labels: ["Minggu Ini", "Minggu Sebelumnya"],
            datasets: [
                {
                    label: 'Data One',
                    backgroundColor: '#f87979',
                    data: [Math.floor(Math.random() * (50 - 5 + 1)) + 5, Math.floor(Math.random() * (50 - 5 + 1)) + 5]
                },
                {
                    label: 'Data One',
                    backgroundColor: 'blue',
                    data: [Math.floor(Math.random() * (50 - 5 + 1)) + 5, Math.floor(Math.random() * (50 - 5 + 1)) + 5]
                }
            ]
        },
        {
            responsive: true,
            maintainAspectRatio: false
        });
    }
}
