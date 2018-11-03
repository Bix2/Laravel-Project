<template>
  <div class="chart chart__activity">
    <weekactivitychart width="100%" height="350" type="bar" :options="chartOptions" :series="series"></weekactivitychart>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
  name: 'BarExample',
  components: {
    weekactivitychart: VueApexCharts,
  },
  data: function() {
    return {
      chartOptions: {
        chart: {
            height: 350,
            type: 'bar',
            stacked: true,
            stackType: '100%'
        },
        plotOptions: {
          bar: {
            horizontal: true
          }
        },
        xaxis: {
          categories: []
        },
        yaxis: {
          title: {
              text: undefined
          },
        },
        dataLabels: {
            enabled: false
        },
        title: {
            align: 'center',
            text: 'Weekly Plan'
        },
        tooltip: {
            shared: false,
            y: {
                formatter: function(val) {
                    return val + " steps"
                }
            }
        },
        fill: {
          colors: ['#E14DA5', '#EAEAEA']
        },
        states: {
          hover: {
            filter: 'none'
          }
        },
        legend: {
          position: 'right',
        }
      },
      series: [{
        name: 'Activity',
        data: []
      },{
        name: 'Goal',
        data: []
      }]
    }
  },
  created: function() {
        var self = this;
        var last7Days = [];
        var daysNotActive = [];
        var daysActive = [];
        var seriesArray = [
            [],
            []
        ];
        for (let i = 0; i < 7; i++) {
            var days = i; // Days you want to subtract
            var date = new Date();
            var last = new Date(date.getTime() - (days * 24 * 60 * 60 * 1000));
            var day = ("0" + last.getDate()).slice(-2);
            var month = ("0" + (last.getMonth() + 1)).slice(-2);
            var year = last.getFullYear();
            var createdDate = year + "-" + month + "-" + day;
            last7Days.push(createdDate);
        }
        self.chartOptions.xaxis.categories = [last7Days[0], last7Days[1], last7Days[2], last7Days[3], last7Days[4], last7Days[5], last7Days[6]];
        axios.get('http://homestead.test/api/getweekactivity')
            .then(function(response) {
                for (let n = 0; n < last7Days.length; n++) {
                    for (let n2 = 0; n2 < response.data[0].activitylogs.length; n2++) {
                        if(last7Days[n] == response.data[0].activitylogs[n2].date) {
                            var data = {
                                    date: last7Days[n],
                                    steps: response.data[0].activitylogs[n2].steps,
                                    goal: response.data[0].goal - response.data[0].activitylogs[n2].steps
                                }
                            daysActive.push(data);
                        }
                    }
                }
                var counter = 0;
                for (let i = 0; i < last7Days.length; i++) {
                    if(daysActive[counter] != undefined) {
                        if(last7Days[i] == daysActive[counter].date) {
                            seriesArray[0].push(daysActive[counter].steps);
                            seriesArray[1].push(daysActive[counter].goal);
                            counter++;
                        } else {
                            seriesArray[0].push(0);
                            seriesArray[1].push(0);
                        }
                    } else {
                        seriesArray[0].push(0);
                        seriesArray[1].push(0);
                    }
                }
                self.series[0].data = seriesArray[0];
                self.series[1].data = seriesArray[1];
        });
  }
}

</script>
