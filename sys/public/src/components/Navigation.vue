<template lang="jade">
div
  aside.menu(v-for="subs, cat in navigation")
    p.menu-label {{ cat }}
    ul.menu-list
      li(v-for="item in subs")
        router-link(v-bind:to="item.to")
          span {{ item.label }}
</template>

<script>
export default {
  name: 'Navigation',
  data () {
    return {
      navigation: {
        'General': [
          // {to: '/', icon: 'dashboard', label: 'Dashboard'},
          {to: '/users', icon: 'user', label: 'Users'},
          {to: '/groups', icon: 'users', label: 'Groups'},
          {to: '/permissions', icon: 'lock', label: 'Permissions'}
        ],
        'Web Properties': [
          {to: '/websites', icon: 'globe', label: 'Websites'}
        ],
        'Publications': [
          {to: '/posts', icon: 'paper-plane', label: 'Posts'},
          {to: '/galleries', icon: 'camera', label: 'Galleries'}
        ]
      }
    }
  }
}
</script>

<style lang="sass" scoped>
.menu-label
  margin-top: 1rem
.router-link-active
  // color: red !important
</style>
