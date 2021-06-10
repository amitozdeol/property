import Vue from 'vue'
import { Sidebar, Menu, Field, Switch, Select, Skeleton } from 'buefy';
import router from './routes';

[Sidebar, Menu, Field, Switch, Select, Skeleton].forEach((x) => Vue.use(x));

Vue.component('app', require('./components/App.vue').default);

//Format date to human readable time
Vue.filter('formatDate', function(value) {
    if (value) {
        let d = new Date(value);
        let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
        let mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d);
        let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
        return `${da}-${mo}-${ye}`;
    }
});

const app = new Vue({
    el: '#app',
    router
});
