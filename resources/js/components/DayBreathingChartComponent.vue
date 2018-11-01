<template>
    <div class="chart">
        <div class="chart__breathing">
            <div :class="breathing.data[0].type" :breathing="breathing"><p>{{ breathing.data[0].title }}</p></div>
            <div :class="breathing.data[1].type" :breathing="breathing"><p>{{ breathing.data[1].title }}</p></div>
            <div :class="breathing.data[2].type" :breathing="breathing"><p>{{ breathing.data[2].title }}</p></div>
            <div :class="breathing.data[3].type" :breathing="breathing"><p>{{ breathing.data[3].title }}</p></div>
            <div :class="breathing.data[4].type" :breathing="breathing"><p>{{ breathing.data[4].title }}</p></div>
        </div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            breathing: {
                data: [{
                    title: '',
                    type: 'nothing'
                },
                {
                    title: '',
                    type: 'nothing'
                },
                {
                    title: '',
                    type: 'nothing'
                },
                {
                    title: '',
                    type: 'nothing'
                },
                {
                    title: '',
                    type: 'nothing'
                }]
            }
        }
    },
    created: function() {
        var self = this;
        var breathingData = [];
        axios.get('http://homestead.test/api/getdaybreathing')
        .then(function(response) {
            for (let i = 0; i < 5; i++) {
                if(response.data[i]) {
                    if(response.data[i].amount == 3) {
                        breathingData.push({
                            title: 'Perfect',
                            type: 'success'
                        })
                    } else {
                        breathingData.push({
                            title: 'Good',
                            type: 'unsuccess'
                        })
                    }
                } else {
                    breathingData.push({
                        title: 'Start session',
                        type: 'nothing'
                    })
                }
            }
            self.breathing.data = breathingData;
        });
    }
}
</script>

<style>
  .chart__breathing {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-column-gap: 1em;
  }

  .chart__breathing div {
    display: grid;
  }

  .chart__breathing div p {
    justify-self: center;
    align-self: center;
    margin: 0;
    padding: 20px;
  }

  .nothing {
    background-color: #EAEAEA;
  }

  .success {
    background-color: #58CFD7;
  }

  .unsuccess {
    background-color: #F9DA69;
  }
</style>