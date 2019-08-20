
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate';
import 'material-design-icons-iconfont/dist/material-design-icons.css';
import './vuetify';
import VueModal from 'vue-js-modal';
import Routes from './routes';
import { store } from './store';
import './filters';


Vue.use(VueRouter);
// Vue.use(Vuex);
Vue.use(VeeValidate);
Vue.use(VueModal);

const router = new VueRouter({
    routes: Routes,
    mode: 'history'
})

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('welcome', require('./components/Welcome.vue'));
Vue.component('cuisines-list', require('./components/CuisinesList.vue'));
Vue.component('cuisine-single', require('./components/Cuisine.vue'));
Vue.component('order-tray', require('./components/OrderTray.vue'));
Vue.component('featured-rests', require('./components/FeaturedRests.vue'));
Vue.component('pop-cuisines', require('./components/PopCuisines.vue'));
Vue.component('pop-outlets', require('./components/PopOutlets.vue'));
Vue.component('reviews', require('./components/reviews.vue'));
Vue.component('our-guarantees', require('./components/OurGuarantees.vue'));
Vue.component('footerxy', require('./components/Footer.vue'));
Vue.component('orders-test', require('./components/OrdersTest.vue'));
// Vue.component('register-pg', require('./components/reg.vue'));
Vue.component('link-tab', require('./components/HomeLinkTab.vue'));
Vue.component('nav-drawer', require('./components/Admin/NavDrawer.vue'));

const app = new Vue({
    el: '#app',
    router,
    store
});
