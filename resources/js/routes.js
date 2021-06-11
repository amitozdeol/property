import Vue from 'vue';
import VueRouter from 'vue-router';
import Properties from './components/views/Property/Properties';
import Property from './components/views/Property/Property';
import AddProperty from './components/views/Property/AddProperty';
import Tenant from './components/views/Tenant';

Vue.use(VueRouter);

const routes = [
  { path: '/property', name: 'property', component: Properties },
  { path: '/property/create', name: 'Create property', component: AddProperty },
  { path: '/property/:id', component: Property },
  { path: '/tenant', name: 'tenant', component: Tenant },
];

const router = new VueRouter({
  routes // short for `routes: routes`
});

export default router;
