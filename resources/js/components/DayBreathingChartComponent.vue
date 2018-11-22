<template>
    <div class="chart">
        <div class="chart__breathing">
            <div v-if="breathing.data[0].type === 'nothing'">
                <div :class="breathing.data[0].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[0].title }}</a></div>
            </div>
            <div v-else-if="breathing.data[0].type === 'success'">
                <div :class="breathing.data[0].type" :breathing="breathing"><p>{{ breathing.data[0].title }}</p></div>
            </div>
            <div v-if="breathing.data[1].type === 'nothing'">
                <div :class="breathing.data[1].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[1].title }}</a></div>
            </div>
            <div v-else-if="breathing.data[1].type === 'success'">
                <div :class="breathing.data[1].type" :breathing="breathing"><p>{{ breathing.data[1].title }}</p></div>
            </div>
            <div v-if="breathing.data[2].type === 'nothing'">
                <div :class="breathing.data[2].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[2].title }}</a></div>
            </div>
            <div v-else-if="breathing.data[2].type === 'success'">
                <div :class="breathing.data[2].type" :breathing="breathing"><p>{{ breathing.data[2].title }}</p></div>
            </div>
            <div v-if="breathing.data[3].type === 'nothing'">
                <div :class="breathing.data[3].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[3].title }}</a></div>
            </div>
            <div v-else-if="breathing.data[3].type === 'success'">
                <div :class="breathing.data[3].type" :breathing="breathing"><p>{{ breathing.data[3].title }}</p></div>
            </div>
            <div v-if="breathing.data[4].type === 'nothing'">
                <div :class="breathing.data[4].type" :breathing="breathing"><a href="/dashboard/breathing/session">{{ breathing.data[4].title }}</a></div>
            </div>
            <div v-else-if="breathing.data[4].type === 'success'">
                <div :class="breathing.data[4].type" :breathing="breathing"><p>{{ breathing.data[4].title }}</p></div>
            </div>
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
        axios.get('/api/getdaybreathing')
        .then(function(response) {
            for (let i = 0; i < 5; i++) {
                if(response.data[i]) {
                    if(response.data[i].amount == 1) {
                        breathingData.push({
                            title: 'Perfect Breathing',
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
