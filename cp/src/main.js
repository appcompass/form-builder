/* global localStorage: false */
var Vue = require('vue')
var VueRouter = require('vue-router')
var VueResource = require('vue-resource')

import routes from './routes'
import App from './App'

import '../src/assets/sass/main.sass'

Vue.use(VueRouter)
Vue.use(VueResource)

Vue.http.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('id_token')
// Vue.http.options.root = ''

Vue.http.interceptors.push((request, next) => {
  next(response => {
    if (response.status === 401) {
      router.push({name: 'login'})
    }
    return response
  })
})

export default Vue

export var router = new VueRouter({
  mode: 'history',
  routes
})

/* eslint-disable no-new */
new Vue({
  router,
  el: '#app',
  template: '<App/>',
  components: { App }
})
