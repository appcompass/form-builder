import Vue from 'vue'
import VueResource from 'vue-resource'

Vue.use(VueResource)

/* eslint-disable no-new */
const State = new Vue({
  name: 'State',
  data () {
    return {
      navigation: undefined
    }
  },
  methods: {
    getNavigation () {
      const api = process.env.API_SERVER
      if (!this.navigation) {
        return this.$http.get(api + 'menus/1')
          .then(response => {
            this.navigation = response.body.collection
            return new Promise((resolve, reject) => {
              return resolve(this.navigation)
            })
          })
      } else {
        return new Promise((resolve, reject) => {
          return resolve(this.navigation)
        })
      }
    }
  }
})

export default State
