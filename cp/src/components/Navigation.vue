<template lang="jade">
div
  aside.menu(v-for="cat in navigation")
    p.menu-label {{ cat.title }}
    ul.menu-list
      li(v-for="item in cat.children")
        router-link(v-bind:to="item.url")
          span {{ item.title }}
</template>

<script>
import State from './State'

export default {
  name: 'Navigation',
  components: { State },
  created () {
    const api = process.env.API_SERVER
    this.$http.get(api + 'menus/1')
      .then(response => {
        this.navigation = response.body.collection
        State.setNavigation(this.navigation)
      })
  },
  data () {
    return {
      navigation: {}
    }
  }
}
</script>

<style lang="sass" scoped>
@import '../assets/sass/variables.sass'
.menu-label
  margin-top: 1rem
.router-link-active
  color: $primary-color !important
</style>
