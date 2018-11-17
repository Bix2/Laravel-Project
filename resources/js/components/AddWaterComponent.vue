<template>
    <div class="water-adding">
        <form @submit="formSubmit">
            <input type="text" id="wateradd" name="wateradd" min="0" max="10000" value="0" v-model="amount">
            <p></p>
            <button id="wateraddbutton">Track water</button>
        </form>
        <p>{{output}}</p>
    </div>
</template>

<script>
export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
              amount: '',
              output: ''
            };
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.post('/api/addwater', {
                    amount: this.amount,
                })
                .then(function (response) {
                    currentObj.output = response.data;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            }
        }
    }
</script>