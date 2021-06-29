import Vue from 'vue'
import { Sidebar, Menu, Field, Switch, Select, Skeleton, Button, Input, Modal, Table } from 'buefy';
import router from './routes';

[Sidebar, Menu, Field, Switch, Select, Skeleton, Button, Input, Modal, Table].forEach((x) => Vue.use(x));

Vue.component('app', require('./components/App.vue').default);

/**
 * Format date to human readable time
 * @param hasDay {Boolean} Show day or not in the returned date
 */
Vue.filter('formatDate', function(value, hasDay = true) {
    if (value) {
        let d = new Date(value);
        let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(d);
        let mo = new Intl.DateTimeFormat('en', { month: 'short' }).format(d);
        let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(d);
        return hasDay ? `${da}-${mo}-${ye}` : `${mo}-${ye}`;
    }
});

//capitalize text
Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
});

const app = new Vue({
    el: '#app',
    router
});
