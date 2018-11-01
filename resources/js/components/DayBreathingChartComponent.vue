<template>
    <div class="chart">
        <div class="breathing breathing--session" :breathing="breathing"><p>{{ breathing.title }}</p></div>
        <div class="breathing breathing--session"><p>Perfect</p></div>
        <div class="breathing breathing--session"><p>Perfect</p></div>
        <div class="breathing breathing--session"><p>Perfect</p></div>
        <div class="breathing breathing--session"><p>Perfect</p></div>
    </div>
</template>

<script>
export default {
    data: function() {
        return {
            breathing: {
                title: 'hello'
            }
        }
    },
    created: function() {
        var self = this;
        axios.get('https://reqres.in/api/users?page=2')
        .then(function(response) {
            self.breathing = response.data.data
        });
    }
}
</script>

<style>
  .chart {
    padding: 20px 20px 0;
    background-color: #fff;
    border-radius: 10px;
  }
</style>