import "./bootstrap";
import Vue from "vue";

Vue.component('Clients', require('./components/Clients.vue').default);

new Vue({el: '#app'});
