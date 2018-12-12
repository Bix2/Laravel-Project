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
        axios.get('/api/getdaywater')
        .then(function(response) {
            if(!(response.data[0].waterlogs.amount >= response.data[0].goal)) {
                waterData = [{
                    title: response.data[0].waterlogs.amount/1000 + "/" + response.data[0].goal/1000 + " - " + (response.data[0].goal/1000 - response.data[0].waterlogs.amount/1000) + ' liter still to drink',
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
