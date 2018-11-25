<template>
    <div class="water-adding">
        <form @submit="formSubmit">
            <div class="water-add-form">
                <input type="number" id="wateradd" class="form-control" name="wateradd" min="0" max="10000" value="0" v-model="amount">
                <button class="btn btn-primary" id="wateraddbutton">Track water</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
              amount: ''
            };
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.post('/api/addwater', {
                    amount: this.amount,
                })
            }
        }
    }
</script>