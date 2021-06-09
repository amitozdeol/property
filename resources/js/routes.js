import Vue from 'vue';
import VueRouter from 'vue-router';
import Property from './components/Property';
import Tenant from './components/Tenant';

Vue.use(VueRouter);

const routes = [
  { path: '/property', name: 'property', component: Property },
  { path: '/tenant', name: 'tenant', component: Tenant },
];

const router = new VueRouter({
  routes // short for `routes: routes`
});

export default router;
