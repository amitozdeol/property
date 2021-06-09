import Vue from 'vue'
import { Sidebar, Menu, Field, Switch, Select } from 'buefy';
import router from './routes';

[Sidebar, Menu, Field, Switch, Select].forEach((x) => Vue.use(x));

Vue.component('app', require('./components/App.vue').default);

const app = new Vue({
    el: '#app',
    router
});
