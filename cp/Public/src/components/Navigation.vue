<template lang="jade">
div
  p.menu-label
    router-link(to="/" exact) Dashboard
  aside.menu(v-for="cat in navigation.full")
    p.menu-label(v-if="!cat.url") {{ cat.title }}
    router-link(v-bind:to="cat.url" exact, v-if="cat.url") {{ cat.title }}
    ul.menu-list.main-nav
      li
      li(v-for="item in cat.children")
        router-link(v-bind:to="item.url")
          span.icon.is-small
            i.fa.is-small(:class="'fa-' + item.icon")
          span {{ item.title }}
</template>

<script>
import Navigation from './State'

export default {
  name: 'Navigation',
  data () {
    return {
      navigation: Navigation
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
.main-nav
  .icon
    margin-right: 10px
    i.fa
      color: #ddd
</style>
