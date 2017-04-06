import Vue from 'vue'
@foreach($routes as $route)
import {!! $route['component'] !!} from './pages{!! $route['full_path'] == '/' ? '/index' : $route['full_path'] !!}'
@endforeach

import axios from 'axios'
import { store } from './app'

const request = axios.create({
  baseURL: '{!! $base_url !!}',
  timeout: 1000,
  headers: {!! !empty($headers) ? str_replace([":", "'", '"', ','],[": ", "\\'", "'", ', '], preg_replace('/"([a-zA-Z_]+[a-zA-Z0-9_]*)":/', '$1:', json_encode($headers, JSON_UNESCAPED_SLASHES))) : '{}' !!}
})

const inBrowser = process.env.VUE_ENV === 'client'

import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
  mode: 'history',
  base: __dirname,
  routes: [
@foreach($routes as $i => $route)
    {
      path: '{!! $route['path'] !!}',
      full_path: '{!! $route['full_path'] !!}',
      name: '{!! $route['name'] !!}',
      meta: {!! str_replace([":", "'", '"', ','],[": ", "\\'", "'", ', '], preg_replace('/"([a-zA-Z_]+[a-zA-Z0-9_]*)":/', '$1:', json_encode($route['meta'], JSON_UNESCAPED_SLASHES))) !!},
      component: {!! $route['component'] !!}
    }@if($i < count($routes)-1),
@endif
@endforeach

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
