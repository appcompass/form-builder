import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import { store } from './app'
{!! $imports !!}

const request = axios.create({
  baseURL: '{!! $base_url !!}',
  timeout: 1000,
  headers: {!! !empty($headers) ? $headers : '{}' !!}
})

const inBrowser = process.env.VUE_ENV === 'client'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: [{!! $routes !!}
  ]
})

router.beforeEach((to, from, next) => {
  // this gets triggered on every route load so we try to prevent it from firing
  // when the content is coming from the server, thus avoiding hydration errors
  // for some reason dispatching out-syncs here, seems like state route won't
  // get updated. @TODO take a look at this low priority
  if (inBrowser && typeof store.state.route.path !== 'undefined') {
    request.get('content' + to.fullPath).then((response) => {
      store.commit('CONTENT', response.data.content)
      next()
    })
  } else {
    next()
  }
})

export default router
