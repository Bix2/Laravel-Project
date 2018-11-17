<template>
    <transition name="modal-fade">
        <div class="modal-mask">
            <div class="modal-wrapper">
                 <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">How are you feeling?</div>
            
                                <div class="card-body">
                                    <form>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" value="bad" id="bad" v-model="feedback">
                                            <label class="form-check-label" for="mood">Bad &#x1F614;</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" value="neutral" id="neutral" v-model="feedback">
                                            <label class="form-check-label" for="mood">Neutral &#x1F610;</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" value="good" id="good" v-model="feedback">
                                            <label class="form-check-label" for="mood">Good &#x1F917;</label>
                                        </div>
                                        <button @click="formSubmit" type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                    <strong>Output:</strong>
                                    <pre>
                                    {{feedback}}
                                    </pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>

  export default {
    mounted() {
            console.log('Component mounted.')
        },
        data: function() {
            return {
              feedback: '',
            };
        },
        methods: {
            formSubmit: function() {
                console.log(this.feedback)
                axios.post('/dashboard', {
                    feedback: this.feedback.selected,
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