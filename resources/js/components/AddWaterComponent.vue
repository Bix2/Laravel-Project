<template>
        <div class="row">
            <div class="col-lg-6 mt-5">
                <h4>Log activity data</h4>
                <div class="card">
                    <form @submit="formSubmit">
                        <div>
                            <label for="wateradd" class="col-12 col-form-label">Amount (liters)</label>
                            <div class="col-12">
                                <input type="number" id="wateradd" class="form-control" name="wateradd" min="0" max="100" step="0.01" value="0.00" v-model="amount">
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="col-12">
                                <button class="btn btn-success form-control" id="wateraddbutton">Log Water</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change goal -->
            <div class="col-lg-6 mt-5">
                <h4>Change drinking goal</h4>
                <div class="card">
                    <form @submit="goalSubmit">
                        <div>
                            <label for="goaladd" class="col-12 col-form-label">Amount (liters)</label>
                            <div class="col-12">
                                <input type="number" id="goaladd" class="form-control" name="goaladd" min="0" max="100" step="0.01" value="0.00" v-model="goal">
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="col-12">
                                <button class="btn btn-success form-control" id="wateraddbutton">Change Goal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
              goal: ''
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
                    location.reload();
                })
            },
            goalSubmit(e) {
                e.preventDefault();
                let currentObj = this;
                axios.post('/api/watergoal', {
                    goal: this.goal,
                })
                .then(function (response) {
                    location.reload();
                })
            }
        }
    }
</script>