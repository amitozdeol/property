import Vue from 'vue'
import { Table, Input } from 'buefy';

Vue.use(Table)
Vue.use(Input)

Vue.component('app', require('./components/App.vue').default);

const app = new Vue({
    el: '#app',
});
