<template>
  <div class="example">
    <apexcharts width="100%" height="auto" type="bar" :options="chartOptions" :series="series"></apexcharts>
  </div>
</template>

<script>
import VueApexCharts from 'vue-apexcharts'
export default {
  name: 'BarExample',
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
                categories: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                
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
                        return val + "K"
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
            data: [44, 55, 41, 37, 22, 43, 21]
        },{
            name: 'REM',
            data: [53, 32, 33, 52, 13, 43, 32]
        },{
            name: 'Deep',
            data: [12, 17, 11, 9, 15, 11, 20]
        },{
            name: 'Awake',
            data: [9, 7, 5, 8, 6, 9, 4]
        }],
    }
  },
  created: function() {
        var self = this;
        axios.get('https://homestead.test/api//api/getstats')
            .then(function(response) {
            console.log(response.data.data);
        });
  }
}

</script>