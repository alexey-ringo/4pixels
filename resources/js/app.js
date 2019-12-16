/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//import VueRouter from 'vue-router';
//Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('users-view-component', require('./components/UsersViewComponent.vue').default);
Vue.component('user-create-component', require('./components/UserCreateComponent.vue').default);
Vue.component('user-edit-component', require('./components/UserEditComponent.vue').default);
Vue.component('sections-view-component', require('./components/SectionsViewComponent.vue').default);
Vue.component('section-create-component', require('./components/SectionCreateComponent.vue').default);
Vue.component('section-edit-component', require('./components/SectionEditComponent.vue').default);

//let routes = [
//    {path: 'users/create',  name: 'user-create', component: UserCreate)},
//    {path: '/shop/:slug?', name: 'category', component: require('./components/CategoryComponent.vue')},
//    {path: '/shop/:slug?', name: 'category', component: require('./components/CategoryComponent.vue')},
//    {path: '/shop/:slug?', name: 'category', component: require('./components/CategoryComponent.vue')},
//    {path: '/shop/:slug?', name: 'category', component: require('./components/CategoryComponent.vue')},
//    {path: '/shop/:slug?', name: 'category', component: require('./components/CategoryComponent.vue')}
//    
//    ];
    
//const router = new VueRouter({
//    mode: 'history',
//    routes
//});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//import router from './router';

const app = new Vue({
    el: '#app',
//    router,
});
