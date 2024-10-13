require('./bootstrap');
window.Vue = require('vue').default;

import Swal from 'sweetalert2';
import VueRouter from 'vue-router';
import App from './App.vue';
import { routes } from './routes';

Vue.use(VueRouter);
window.Swal = Swal;

window.Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 1000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

function loggedIn(){
  return localStorage.getItem('token')
}

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)){
    if(!loggedIn()){
      next({
        path: '/login',
        query: {redirect: to.fullPath}
      })
    }else{
      next()
    }
  }else{
    next()
  }
})

const app = new Vue({
    el: '#app',
    router: router,
    render: h => h(App),
});
