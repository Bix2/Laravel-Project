<template>
    <div class="chart">
        <div class="chart__breathing">
            <div :class="breathing.data[0].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[0].title }}</a></div>
            <div :class="breathing.data[1].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[1].title }}</a></div>
            <div :class="breathing.data[2].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[2].title }}</a></div>
            <div :class="breathing.data[3].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[3].title }}</a></div>
            <div :class="breathing.data[4].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[4].title }}</a></div>
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
