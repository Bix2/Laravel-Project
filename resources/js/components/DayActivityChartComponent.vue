<template>
  <div class="chart">
    <apexcharts width="100%" height="350" type="donut" :options="chartOptions" :series="series"></apexcharts>
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
      chartOptions: {
        chart: {
            height: 350,
            type: 'radialBar',
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
            enabled: false,
        },
        labels: ["Steps made", "Steps to go"],
        title: {
            align: 'center',
            text: 'Weekly Plan'
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
      series: [4567, 10000],
    }
  },
  created: function() {
    var self = this;
    axios.get('http://homestead.test/api/getdayactivity')
      .then(function(response) {
        self.series = [response.data[0].activitylogs.steps, response.data[0].goal - response.data[0].activitylogs.steps];
    });
  }
}
</script>
