import Vue from 'vue';
import VueRouter from 'vue-router';
import Property from './components/views/Property';
import AddProperty from './components/views/AddProperty';
import Tenant from './components/views/Tenant';

Vue.use(VueRouter);

const routes = [
  { path: '/property', name: 'property', component: Property },
  { path: '/property/create', name: 'Create property', component: AddProperty },
  { path: '/tenant', name: 'tenant', component: Tenant },
];

const router = new VueRouter({
  routes // short for `routes: routes`
});

export default router;
