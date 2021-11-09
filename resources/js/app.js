import Vue from "vue";

require('./bootstrap');

window.Vue = require('vue');
Vue.component('pagination', require('laravel-vue-pagination'));

///// vue router
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import routes from './routes'
const router = new VueRouter({
    mode:'history',
    routes // short for `routes: routes`
})
//// install swal alert
import Swal from 'sweetalert2';
window.Swal=Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast=Toast;

import MyContent from "./components/MyContent";
const app = new Vue({
    router,
    el: '#app',
    components: {
        MyContent

    }
});
