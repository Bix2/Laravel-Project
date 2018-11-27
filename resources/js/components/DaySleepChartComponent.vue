<template>
  <div class="chart chart__sleep">
    <daysleepchart height="350" type="donut" :options="chartOptions" :series="series"></daysleepchart>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    name: 'DonutExample',
    components: {
        daysleepchart: VueApexCharts,
    },
    data: function() {
        return {
            chartOptions: {
                responsive: [{
                    breakpoint: 1007,
                    options: {
                        chart: {
                            height: 200
                        },
                    },
                }],
                chart: {
                    height: 350,
                    type: 'donut',
                },
                plotOptions: {
                    radialBar: {
                        horizontal: false,
                        columnWidth: '50%',
                        dataLabels: {
                            position: '50%',
                        }
                    },
                },
                dataLabels: {
                    enabled: true,
                    style: {
                        colors: ['#fff']
                    },
                },
                labels: ["Minutes asleep", "Minutes to sleep "],
                title: {
                    align: 'center',
                    text: 'Daily Goal'
                },
                fill: {
                    colors: ['#E14DA5', '#EAEAEA']
                },
                legend: {
                    show: true,
                    showForSingleSeries: true,
                    position: 'bottom',
                    horizontalAlign: 'center', 
                    verticalAlign: 'middle',
                    labels: {
                        color: '#E14DA5',
                        useSeriesColors: true
                    },
                    markers: {
                        size: 6,
                        strokeColor: "#000",
                        strokeWidth: 0,
                        offsetX: 0,
                        offsetY: 0,
                        radius: 4,
                        shape: "circle"
                    },
                }
            },
            series: [0, 480],
        }
    },
    created: function() {
        var self = this;
            axios.get('/api/getdaysleep')
                .then(function(response) {
                    var totalSleep = response.data[0].sleeplogs.light_minutes + response.data[0].sleeplogs.rem_minutes + response.data[0].sleeplogs.deep_minutes + response.data[0].sleeplogs.wake_minutes;
                    var goal = response.data[0].goal;
                    // check if data from api is ok
                    self.series = [parseInt(totalSleep), goal - totalSleep];
            });
    }
}

</script>

