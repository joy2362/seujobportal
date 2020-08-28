require('./bootstrap');

import Vue from 'vue'
import VueRouter from 'vue-router'
import {routes} from './route'
import Vuetify from "../plugins/vuetify";
import Typewriter from 'vue-typewriter'
import Vuelidate from 'vuelidate'
import Swal from 'sweetalert2'
import User from './helper/User'


window.Notification = Notification;
window.Swal = Swal;
window.user=User;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

window.Toast=Toast;

Vue.use(VueRouter)
Vue.use(Typewriter)
Vue.use(Vuelidate)
//post filter (forum post short view)
Vue.filter('sortPost',val=>{
    if(!val || typeof (val)!= 'string') return ''
    val = val.slice(0,20)
    val= val+'...';
    return val
})
const router = new VueRouter({
    routes,
    mode: 'history',
});
const app = new Vue({
    el: '#app',
    vuetify: Vuetify,
    router
});
