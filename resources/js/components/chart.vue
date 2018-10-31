<template>
  <div class="example">
    <apexcharts width="100%" height="auto" type="bar" :options="chartOptions" :series="series"></apexcharts>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
  name: 'apexcharts',
  components: {
    apexcharts: VueApexCharts,
  },
  data: function() {
    return {
        chartOptions: {
            chart: {
                height: 350,
                type: 'bar',
                stacked: true,
                shadow: {
                    enabled: true,
                    blur: 1,
                    opacity: 0.5
                }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '60%',
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
            },
            xaxis: {
                categories: [],
                
            },
            yaxis: {
                title: {
                    text: undefined
                },
            },
            title: {
                text: 'Compare Sales Strategy'
            },
            tooltip: {
                shared: false,
                y: {
                    formatter: function(val) {
                        return val + " min"
                    }
                }
            },
            states: {
                hover: {
                    filter: 'none'
                }
            },
            fill: {
                colors: ['#E14DA5', '#F9DA69', '#AB64E1', '#58CFD7']
            },
            legend: {
                position: 'right',
            },
        },
        series: [{
            name: 'Light',
            data: []
        },{
            name: 'REM',
            data: []
        },{
            name: 'Deep',
            data: []
        },{
            name: 'Awake',
            data: []
        }],
    }
  },
  created: function() {
    var self = this;
    var last7Days = [];
    var daysNotActive = [];
    var daysActive = [];
    for (let i = 0; i < 7; i++) {
        var days = i; // Days you want to subtract
        var date = new Date();
        var last = new Date(date.getTime() - (days * 24 * 60 * 60 * 1000));
        var day =last.getDate();
        var month=last.getMonth()+1;
        var year=last.getFullYear();
        var createdDate = year + "-" + month + "-" + day;
        last7Days.push(createdDate);
    }
    self.chartOptions.xaxis.categories = [last7Days[0], last7Days[1], last7Days[2], last7Days[3], last7Days[4], last7Days[5], last7Days[6]];
        axios.get('http://homestead.test/api/getweeksleep')
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
                    console.log(daysActive[counter]);
                    if(daysActive[counter] != undefined) {
                        if(last7Days[i] == daysActive[counter].date) {
                            self.series[0].data.push(daysActive[counter].lightSleep);
                            self.series[1].data.push(daysActive[counter].remSleep);
                            self.series[2].data.push(daysActive[counter].deepSleep);
                            self.series[3].data.push(daysActive[counter].wakeSleep);
                            counter++;
                        } else {
                            self.series[0].data.push(0);
                            self.series[1].data.push(0);
                            self.series[2].data.push(0);
                            self.series[3].data.push(0);
                        }
                    } else {
                        self.series[0].data.push(0);
                        self.series[1].data.push(0);
                        self.series[2].data.push(0);
                        self.series[3].data.push(0);
                    }
                }
        });
  }
}

</script>