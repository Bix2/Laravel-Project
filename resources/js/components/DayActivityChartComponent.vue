<template>
  <div class="chart chart__activity">
    <apexcharts height="350" type="radialBar" :options="options" :series="series"></apexcharts>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
  name: 'DonutExample',
  components: {
    apexcharts: VueApexCharts,
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
                        image: '../../images/exercise-dark.svg',
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
                                return parseInt(val) + "%";
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
                colors: ['#EC65B7', '#EC65B7'],
                gradient: {
                    shade: 'light',
                    type: 'horizontal',
                    shadeIntensity: 0.2,
                    gradientToColors: ['#EC65B7', '#EC65B7'],
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100]
                }
            },
            stroke: {
                lineCap: 'round'
            },
            labels: ['Steps'],
            }
    }
  },
  created: function() {
    var self = this;
    axios.get('/api/getdayactivity')
      .then(function(response) {
        var totalSteps = response.data[0].activitylogs.steps;
        var goal = response.data[0].goal;
        //self.series = [parseInt(Math.round(totalSteps))];
        var totalPercent = (totalSteps / goal * 100).toFixed(2);
        if(totalPercent > 100) {
            totalPercent = 100;
        }
        self.series = [totalPercent];

    });
  }
}
</script>


