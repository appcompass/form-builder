/* global localStorage: false */
import Vue, {router} from '../main.js'

export default {
  user: {
    authenticated: false,
    profile: null
  },
  check () {
    if (localStorage.getItem('id_token') !== null) {
      // Vue.http.get(
      //   process.env.API_SERVER + 'api/user',
      //   ).then(response => {
      //     this.user.authenticated = true
      //     this.user.profile = response.data.data
      //   })
    } else {
      router.push({ name: 'login' })
    }
  },
  login (context, email, password) {
    Vue.http.post(
      process.env.API_SERVER + 'auth/login',
      // 'https://api.p3in.com/auth/login',
      {
        email: email,
        password: password
      }
      ).then(response => {
        context.error = false
        console.log(response.data.access_token)
        localStorage.setItem('id_token', response.data.access_token)
        Vue.http.headers.common['access_token'] = 'Bearer ' + localStorage.getItem('id_token')

        this.user.authenticated = true
        this.user.profile = response.data.data

        router.push({
          name: 'dashboard'
        })
      }, response => {
        context.error = true
      })
  },
  logout () {
    localStorage.removeItem('id_token')
    this.user.authenticated = false
    this.user.profile = null

    router.push({
      name: 'home'
    })
  },
  register (context, name, email, password) {
    Vue.http.post(
      process.env.API_SERVER + 'api/register',
      {
        name: name,
        email: email,
        password: password
      }
      ).then(response => {
        context.success = true
      }, response => {
        context.response = response.data
        context.error = true
      })
  }
}
