<template>
  <div class="chart">
    <daysleepchart width="100%" height="350" type="bar" :options="chartOptions" :series="series"></daysleepchart>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    name: 'BarExample',
    components: {
        daysleepchart: VueApexCharts,
    },
    data: function() {
        return {
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'bar',
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '50%',
                        dataLabels: {
                            position: '50%',
                        }
                    },
                },
                xaxis: {
                    categories: ["Light", "REM", "Deep", "Awake"],
                    position: 'top',
                    labels: {
                        offsetY: -18,

                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + " min"
                            }
                        }
                    }
                },
                fill: {
                    colors: ['#E14DA5', '#F9DA69', '#AB64E1', '#58CFD7']
                },
                title: {
                    text: 'Daily Plan',
                    // floating: true,
                    // offsetY: 320,
                    align: 'center',
                    style: {
                        color: '#444'
                    }
                },
            },
            series: [{
                name: 'Light',
                data: [0]
            }, {
                name: 'REM',
                data: [0]
            }, {
                name: 'Deep',
                data: [0]
            }, {
                name: 'Awake',
                data: [0]
            }],
        }
    },
    created: function() {
        var self = this;
            axios.get('http://homestead.test/api/getdaysleep')
                .then(function(response) {
                    if(response.data) {
                        self.series[0].data = [response.data.light_minutes];
                        self.series[1].data = [response.data.rem_minutes];
                        self.series[2].data = [response.data.deep_minutes];
                        self.series[3].data = [response.data.wake_minutes];
                    } else {
                        self.series[0].data = [0];
                        self.series[1].data = [0];
                        self.series[2].data = [0];
                        self.series[3].data = [0];
                    }
            });
    }
}

</script>

<style>
  .chart {
    padding: 20px 20px 0;
    background-color: #fff;
    border-radius: 10px;
  }
</style>