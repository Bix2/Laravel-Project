
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');
require('./breathingsession');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('modal-component', require('./components/form.vue'));
// Vue.component('form-component', require('./components/form.vue'));

// const app = new Vue({
//     el: '#main',
//     methods: {
//         showModal () {
//           this.$refs.feedbackModal.show();
//         },
//         hideModal () {
//           this.$refs.feedbackModal.hide();
//         }
//     }
// });

Vue.component('weeksleepchart', require('./components/WeekSleepChartComponent.vue'));
Vue.component('daysleepchart', require('./components/DaySleepChartComponent.vue'));
Vue.component('weekactivitychart', require('./components/WeekActivityChartComponent.vue'));
Vue.component('apexcharts', require('./components/DayActivityChartComponent.vue'));
Vue.component('daybreathingchart', require('./components/DayBreathingChartComponent.vue'));
Vue.component('daywaterchart', require('./components/DayWaterChartComponent.vue'));
Vue.component('addwater', require('./components/AddWaterComponent.vue'));

var app = new Vue({
  el: '#app'
})

$('.alert__close').on('click', function(e) {
  e.preventDefault();
  $(this).parent('.alert').hide('slow');
});

$('.tooltip-items').tooltip();

// $.ajaxSetup({
//   headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//   }
// });