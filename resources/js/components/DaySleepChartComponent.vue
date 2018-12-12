<template>
  <div class="chart chart__sleep">
    <daysleepchart height="350" type="radialBar" :options="options" :series="series"></daysleepchart>
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
        series: [0],
        options: {
            chart: {
                height: 350,
                type: 'radialBar',
            },
            responsive: [{
                breakpoint: 1007,
                options: {
                    chart: {
                        height: 200
                    },
                },
            }],
            plotOptions: {
                radialBar: {
                    hollow: {
                        margin: 5,
                        size: '70%',
                        image: '../../images/sleep-dark.svg',
                        imageWidth: 40,
                        imageHeight: 40,
                        imageClipped: false
                    },
                    dataLabels: {
                        name: {
                            offsetY: 0,
                            show: false,
                            color: '#888',
                            fontSize: '16px'
                        },
                        value: {
                            formatter: function(val) {
                                var value = val + "%";
                                // return (Math.floor(val1 / 60) + "h ") + Math.floor(val1 % 60) + "min";
                                return value;
                            },
                            color: '#111',
                            fontSize: '20px',
                            show: true,
                            offsetY: 70,
                        },
                    }
                }
            },
            title: {
                align: 'center',
                text: 'Daily Progress'
            },
            fill: {
                type: 'gradient',
                colors: ['#F3E07C', '#F3E07C'],
                gradient: {
                    shade: 'light',
                    type: 'horizontal',
                    shadeIntensity: 0.2,
                    gradientToColors: ['#F3E07C', '#F3E07C'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Hours'],
            }
    }
  },
    created: function() {
        var self = this;
            axios.get('/api/getdaysleep')
                .then(function(response) {
                    var totalSleep = response.data[0].sleeplogs.light_minutes + response.data[0].sleeplogs.rem_minutes + response.data[0].sleeplogs.deep_minutes;
                    var sleepgoal = response.data[0].goal;
                    var totalPercent = parseInt(totalSleep / sleepgoal * 100);
                    if(totalPercent > 100) {
                        totalPercent = 100;
                    }
                    self.series = [totalPercent];
            });
    }
}

</script>

