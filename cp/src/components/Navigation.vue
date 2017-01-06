<template lang="jade">
div
  aside.menu(v-for="cat in navigation")
    p.menu-label {{ cat.label }}
    ul.menu-list
      li(v-for="item in cat.children")
        router-link(v-bind:to="item.url")
          span {{ item.label }}
</template>

<script>
export default {
  name: 'Navigation',
  created () {
    const api = process.env.API_SERVER
    this.$http.get(api + 'menus/1')
      .then(response => {
        this.navigation = response.body.collection
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
