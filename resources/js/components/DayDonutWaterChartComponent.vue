<template>
  <div class="chart chart__water--donut">
    <daydonutwaterchart height="350" type="radialBar" :options="options" :series="series"></daydonutwaterchart>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    name: 'DonutExample',
    components: {
        daydonutwaterchart: VueApexCharts,
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
                        image: '../../images/water-dark.svg',
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
                            goal: 2000,
                            formatter: function(val) {
                                var val1 = val + " liters";
                                return val1;
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
                colors: ['#76D4DB', '#76D4DB'],
                gradient: {
                    shade: 'light',
                    type: 'horizontal',
                    shadeIntensity: 0.2,
                    gradientToColors: ['#76D4DB', '#76D4DB'],
                    inverseColors: false,
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Liters'],
            }
    }
  },
    created: function() {
        var self = this;
            axios.get('/api/getdaywater')
                .then(function(response) {
                    var totalWater = response.data[0].waterlogs.amount;
                    var waterGoal = response.data[0].goal;
                    var totalPercent = parseInt(totalWater / waterGoal * 100);
                    if(totalPercent > 100) {
                        totalPercent = 100;
                    }
                    self.options.plotOptions.radialBar.dataLabels.value.formatter = function(totalPercent) {
                                var val1 = totalPercent + " coco";
                                return val1;
                            };
                    self.series = [totalPercent];
            });
    }
}

</script>

