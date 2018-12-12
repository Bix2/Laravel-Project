<template>
  <div class="chart chart__water--donut">
    <daydonutbreathingchart height="350" type="radialBar" :options="options" :series="series"></daydonutbreathingchart>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
    name: 'DonutExample',
    components: {
        daydonutbreathingchart: VueApexCharts,
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
                        image: '../../images/breathing-dark.svg',
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
                                // if(value == 1) {
                                //     value = value + " session";
                                // } else {
                                //     value = value + " sessions";
                                // }
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
                colors: ['#A86AE9', '#EC65B7'],
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'horizontal',
                    shadeIntensity: 0.2,
                    gradientToColors: ['#A86AE9', '#EC65B7'],
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
            axios.get('/api/getdaybreathing')
                .then(function(response) {
                    var totalBreathing = response.data.length;
                    var breathingGoal = 5;
                    var totalPercent = parseInt(totalBreathing / breathingGoal * 100);
                    if(totalPercent > 100) {
                        totalPercent = 100;
                    }
                    self.series = [totalPercent];
            });
    }
}

</script>

