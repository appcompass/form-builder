import Vue from '../main.js'

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

export default {
  full: null,
  init () {
    const api = process.env.API_SERVER
    return Vue.http.get(api + 'menus/1')
      .then(response => {
        this.full = response.body.collection
      })
  },
  get (route) {
    if (this.full === null) {
      return this.init()
        .then(() => {
          return this.search(route)
        })
    } else {
      return this.search(route)
    }
  },
  search (route) {
    return new Promise((resolve, reject) => {
      if (route) {
        let part = findObject(route.charAt(0).toUpperCase() + route.slice(1), this.full)
        return resolve(part)
      } else {
        return resolve(this.full)
      }
    })
  },
  clear () {
    this.full = null
  }
}
