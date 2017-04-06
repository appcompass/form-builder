import Vue from 'vue'
import App from './App.vue'
import VueMeta from 'vue-meta'
import store from './vuex/store'
import router from './router'
import { sync } from 'vuex-router-sync'

Vue.use(VueMeta)

sync(store, router)

const app = new Vue({
  router,
  store,
  ...App
})

export { app, router, store }
