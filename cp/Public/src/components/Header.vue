<template lang="jade">
header
  .nav.has-shadow
    .container
      .nav-left
        router-link.nav-item(to="/")
          img(src="../assets/images/content/p3_logo-01.png")
      .nav-right
        a.nav-item(v-if="!auth.user.authenticated") Login
        a.nav-item.is-tab(v-if="auth.user.authenticated", @click="auth.logout()")
          figure.image.is-16x16
            img(:src="auth.user.profile.gravatar_url")
          | &nbsp; Logout
        a.nav-item.is-tab(v-if="auth.user.authenticated") Profile
</template>

<script>
import auth from './Auth.js'

export default {
  name: 'Header',
  data () {
    return {
      auth: auth
    }
  },
  methods: {
    logout () {
      auth.logout()
    }
  },
  mounted () {
    auth.check()
  }
}
</script>

<style lang="sass" scoped>
.nav
  background: rgb(243, 243, 243)
</style>
