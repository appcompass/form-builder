import Vue from 'vue'
import VueResource from 'vue-resource'

Vue.use(VueResource)

function findObject (title, haystack, res) {
  for (let i = 0; i < haystack.length; i++) {
    let current = haystack[i]
    if (current.title === title) {
      res = current.children
    } else if (current.children.length) {
      res = findObject(title, current.children, res)
    }
  }

  return res
}

/* eslint-disable no-new */
const State = new Vue({
  name: 'State',
  data () {
    return {
      navigation: undefined
    }
  },
  methods: {
    getNavigation (route) {
      const api = process.env.API_SERVER
      console.log(route)
      if (!this.navigation) {
        return this.$http.get(api + 'menus/1')
          .then(response => {
            this.navigation = response.body.collection
            return new Promise((resolve, reject) => {
              if (route) {
                // console.log('returning specific nav')
                let navigation = findObject(route.charAt(0).toUpperCase() + route.slice(1), this.navigation)
                return resolve(navigation)
              } else {
                // console.log('returning full navigation')
                return resolve(this.navigation)
              }
            })
          })
      } else {
        return new Promise((resolve, reject) => {
          if (route) {
            // console.log('returning specific nav')
            let navigation = findObject(route.charAt(0).toUpperCase() + route.slice(1), this.navigation)
            return resolve(navigation)
          } else {
            // console.log('returning full navigation')
            return resolve(this.navigation)
          }
        })
      }
    }
  }
})

export default State
