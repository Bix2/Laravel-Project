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
                        imageWidth: 64,
                        imageHeight: 64,
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
                                return Math.round((val / 100) * 10000) +  " steps";
                            },
                            color: '#111',
                            fontSize: '20px',
                            show: true,
                            offsetY: 70,
                        },
                        total: {
                             formatter: function(val) {
                                return (val/this.goal) * 100;                            
                            },
                            color: '#111',
                            fontSize: '20px',
                            show: true,
                            offsetY: 70,
                        }
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                shade: 'dark',
                type: 'horizontal',
                shadeIntensity: 0.5,
                gradientToColors: ['#ABE5A1'],
                inverseColors: true,
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
        self.series = [(totalSteps / goal * 100).toFixed(2)];

    });
  }
}
</script>


