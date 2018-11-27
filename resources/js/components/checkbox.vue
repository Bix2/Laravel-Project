<template>
    <input type="checkbox" class="checkbox" v-model="data.finished" @click="updateTodo"></template>
<script>

  export default {
        data() {
            return {
              finished: false,
            };
        },
        methods: {
            formSubmit: function() {
                axios.post('/dashboard', {
                    toggle: this.toggle,
                })
                .then(function (response) {
                    currentObj.output = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
        }
  };
</script>