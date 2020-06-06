import Vue from 'vue';
import Router from 'vue-router';
import Home from './components/Home.vue';
import UserShow from './views/users/Show.vue';

Vue.use(Router);

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home,
      meta: { title: null }
    },
    {
      path: '/users/:userId',
      name: 'Show',
      component: UserShow,
      meta: { title: 'profile' }
    }
  ]
})