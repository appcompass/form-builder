import Vue from 'vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'

import App from './App'

import Home from './components/Home'
import Bus from './components/Bus'
import Solutions from './components/Solutions'
import Projects from './components/Projects'

import '../raw/source/assets/sass/main.scss'
require('magnific-popup')

Vue.use(VueRouter)
Vue.use(VueResource)

const routes = [
  {
    path: '/',
    component: Home
  },
  {
    path: '/solutions',
    component: Solutions
  },
  {
    path: '/projects',
    component: Projects
  }
]

const router = new VueRouter({
  mode: 'history',
  routes,
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
})

router.beforeEach((to, from, next) => {
  if (to.hash.indexOf('#') > -1) {
    Bus.$emit('modal', {type: to.hash.slice(1)})
  }
  return next()
})

/* eslint-disable no-new */
new Vue({
  router,
  el: '#main',
  data () {
    return {
      modal: undefined
    }
  },
  mounted () {},
  components: { App }
})
