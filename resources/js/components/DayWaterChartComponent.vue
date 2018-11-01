<template>
    <div class="chart">
        <div class="chart__water">
            <div class="chart__water--title">
                <p :water="water">{{ water.data[0].title }}</p>
            </div>
            <div class="amount" v-bind:style="{ width: water.data[0].amount + '%' }"></div>
            <div class="goal"></div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            water: {
                data: [{
                    title: '',
                    amount: '',
                    goal: ''
                }]
            }
        }
    },
    created: function() {
        var self = this;
        var waterData = [];
        axios.get('http://homestead.test/api/getdaywater')
        .then(function(response) {
            if(!(response.data[0].waterlogs.amount >= response.data[0].goal)) {
                waterData = [{
                    title: response.data[0].waterlogs.amount + "/" + response.data[0].goal + " - " + (response.data[0].goal - response.data[0].waterlogs.amount) + ' ml still to drink',
                    amount: response.data[0].waterlogs.amount / response.data[0].goal * 100,
                    goal: 100 - (response.data[0].waterlogs.amount / response.data[0].goal * 100)
                }]
            } else {
                waterData = [{
                    title: 'Great! Your goal has been reached',
                    amount: 100,
                    goal: 100
                }]
            }
            self.water.data = waterData;
        });
    }
}
</script>

<style>
  .chart__water {
      width: 100%;
      position: relative;
  }

  .chart__water .amount {
      background-color: #58CFD7;
      position: absolute;
      z-index: 2;
  }

  .chart__water .goal {
      background-color: #EAEAEA;
      position: relative;
      width: 100%;
  }

  .chart__water .chart__water--title {
        padding: 0;
        position: absolute;
        z-index: 3;
        display: grid;
        grid-template-columns: 1fr;
        width: 100%;
        height: 100%;
  }

  .chart__water .chart__water--title p {
      margin: 0;
  }

  .chart__water--title p {
      align-self: center;
      justify-self: center;
  }

  .chart__water div {
      padding: 30px;
  }
</style>