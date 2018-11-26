<template>
  <div class="chart chart__activity">
    <apexcharts height="350" type="donut" :options="options" :series="series"></apexcharts>
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
      options: {
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
            type: 'radialBar',
        },
        plotOptions: {
            radialBar: {
                horizontal: false,
            },
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff']
            },
        },
        labels: ["Steps made", "Steps to go"],
        title: {
            align: 'center',
            text: 'Daily Plan'
        },
        fill: {
            colors: ['#E14DA5', '#EAEAEA']
        },
      },
      series: [0, 10000],
    }
  },
  created: function() {
    var self = this;
    axios.get('/api/getdayactivity')
      .then(function(response) {
        self.series = [response.data[0].activitylogs.steps, response.data[0].goal - response.data[0].activitylogs.steps];
    });
  }
}
</script>

