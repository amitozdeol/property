import Vue from 'vue';
import VueRouter from 'vue-router';
import Dashboard from './components/views/Dashboard/Index';
import Properties from './components/views/Property/Index';
import Property from './components/views/Property/Property';
import AddProperty from './components/views/Property/AddProperty';
import Tenant from './components/views/Tenant/Index';

Vue.use(VueRouter);

const routes = [
  { path: '/', name: 'dashboard', component: Dashboard },
  { path: '/property', component: Properties, name: 'property', meta: {name: 'property'}},
  { path: '/property/create', component: AddProperty, name: 'Create property', meta: {name: 'property'} },
  { path: '/property/:id', component: Property, meta: {name: 'property'} },
  { path: '/tenant', name: 'tenant', component: Tenant },
];

const router = new VueRouter({
  routes // short for `routes: routes`
});

export default router;
