<template>
  <div id="chart_sleep" class="chart chart__sleep">
    <weeksleepchart height="350" type="bar" :options="chartOptions" :series="series"></weeksleepchart>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
  name: 'BarExample',
  components: {
    weeksleepchart: VueApexCharts,
  },
  data: function() {
    return {
    series: [{
      name: 'Light',
      data: [0, 0, 0, 0, 0, 0, 0]
    },{
      name: 'REM',
      data: [0, 0, 0, 0, 0, 0, 0]
    },{
      name: 'Deep',
      data: [0, 0, 0, 0, 0, 0, 0]
    },{
      name: 'Awake',
      data: [0, 0, 0, 0, 0, 0, 0]
    }],
    chartOptions: {
      responsive: [{
        breakpoint: 1007,
        options: {
          legend: {
            position: 'bottom'
          }
        }
      }],
      chart: {
          // height: 350,
          // type: 'bar',
          stacked: true,
          id: 'chart_sleep'
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
          colors: ['#E14DA5', '#F9DA69', '#AB64E1', '#58CFD7'],
          shared: false,
          y: {
              formatter: function(val) {
                  return val + " min"
              }
          }
      },
      fill: {
        colors: ['#E14DA5', '#F9DA69', '#AB64E1', '#58CFD7']
      },
      states: {
        hover: {
          filter: 'none'
        }
      },
      legend: {
        position: 'right',
      }
    }
  }
  },
  created: function() {
    var self = this;
    var last7Days = [];
    var daysNotActive = [];
    var daysActive = [];
    var seriesArray = [
      [],
      [],
      [],
      []
    ];
    for (let i = 0; i < 7; i++) {
        var days = i; // Days you want to subtract
        var date = new Date();
        var last = new Date(date.getTime() - (days * 24 * 60 * 60 * 1000));
        var day = ("0" + last.getDate()).slice(-2);
        var month = last.getMonth()+1;
        var year = last.getFullYear();
        var createdDate = year + "-" + month + "-" + day;
        last7Days.push(createdDate);
    }
    self.chartOptions.xaxis.categories = [last7Days[0], last7Days[1], last7Days[2], last7Days[3], last7Days[4], last7Days[5], last7Days[6]];
        axios.get('/api/getweeksleep')
            .then(function(response) {
                for (let n = 0; n < last7Days.length; n++) {
                    for (let n2 = 0; n2 < response.data.length; n2++) {
                        if(last7Days[n] == response.data[n2].date_of_sleep) {
                            var data = {
                                    date: last7Days[n],
                                    lightSleep: response.data[n2].light_minutes,
                                    remSleep: response.data[n2].rem_minutes,
                                    wakeSleep: response.data[n2].wake_minutes,
                                    deepSleep: response.data[n2].deep_minutes
                                }
                            daysActive.push(data);
                        }
                    }
                }
                var counter = 0;
                for (let i = 0; i < last7Days.length; i++) {
                    if(daysActive[counter] != undefined) {
                        if(last7Days[i] == daysActive[counter].date) {
                            seriesArray[0].push(parseInt(daysActive[counter].lightSleep));
                            seriesArray[1].push(parseInt(daysActive[counter].remSleep));
                            seriesArray[2].push(parseInt(daysActive[counter].deepSleep));
                            seriesArray[3].push(parseInt(daysActive[counter].wakeSleep));
                            counter++;
                        } else {
                            seriesArray[0].push(0);
                            seriesArray[1].push(0);
                            seriesArray[2].push(0);
                            seriesArray[3].push(0);
                        }
                    } else {
                        seriesArray[0].push(0);
                        seriesArray[1].push(0);
                        seriesArray[2].push(0);
                        seriesArray[3].push(0);
                    }
                }
                console.log(seriesArray[0]);
                console.log(seriesArray[1]);
                console.log(seriesArray[2]);
                console.log(seriesArray[3]);
                self.series[0].data = seriesArray[0];
                self.series[1].data = seriesArray[1];
                self.series[2].data = seriesArray[2];
                self.series[3].data = seriesArray[3];
        });
  }
}

</script>

