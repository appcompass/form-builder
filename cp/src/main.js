import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'
import store from './store'

import App from './App'
import Home from './components/Home'
import ListView from './components/ListView'
import EditView from './components/EditView'
// import SubView from './components/SubView'
import CreateView from './components/CreateView'

import 'assets/sass/main.sass'

Vue.use(VueRouter) // router
Vue.use(VueResource) // $http

const routes = [
  {
    path: '/',
    name: 'dashboard',
    component: Home,
    meta: {
      name: 'Home' // will be pushed in breadcrumbs
    }
  }, {
    path: '/:model',
    name: 'list',
    component: ListView,
    meta: {
      name: ''
    }
  }, {
    path: '/:model/create',
    name: 'create',
    component: CreateView
  }, {
    path: '/:model/:id',
    name: 'edit',
    component: EditView,
    meta: {
      name: ''
    },
    children: [
      {
        path: ':sub',
        component: ListView,
        name: 'sub',
        meta: {
          name: ''
        },
        children: [
          {
            path: ':model/:id',
            name: 'edit',
            component: EditView
          }
        ]
      }
    ]
  }
]

const router = new VueRouter({
  mode: 'history',
  routes
})

/* eslint-disable no-new */
new Vue({
  store,
  router,
  el: '#app',
  template: '<App/>',
  components: { App }
})
