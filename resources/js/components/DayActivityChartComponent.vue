<template>
  <div class="chart chart__activity">
    <apexcharts height="350" type="donut" :options="options" :series="series"></apexcharts>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
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
        labels: ["Steps made", "Steps to go"],
        title: {
            align: 'center',
            text: 'Daily Plan'
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

