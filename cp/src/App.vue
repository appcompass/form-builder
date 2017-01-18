<template lang="jade">
#app
  .nav.has-shadow
    .container
      .nav-left
        router-link.nav-item(to="/")
          img(src="./assets/images/content/p3_logo-01.png")
      .nav-right
        a.nav-item(v-if="!auth.user.authenticated") Login
        a.nav-item.is-tab(v-if="auth.user.authenticated", @click="auth.logout()")
          figure.image.is-16x16
            img(:src="auth.user.profile.gravatar_url")
          | &nbsp; Logout
        a.nav-item.is-tab(v-if="auth.user.authenticated") Profile
  div.section
    .columns
      .column.is-2
        Navigation
      .column
        transition(name="route", mode="out-in")
          router-view
  footer.footer
    .container
      .content.has-text-centered
        p Built with
          span.icon.is-small
            i.fa.fa-heart
          |  by
          a(href="https://www.p3in.com")  Plus Three Interactive.
        p The source code is licensed
          a(href="http://opensource.org/licenses/mit-license.php")  MIT.
          |  The website content is licensed
          a(href="http://creativecommons.org/licenses/by-nc-sa/4.0/")  CC ANS 4.0
        p
          a.icon(href="https://github.com/plus3interactive/")
            i.fa.fa-github
</template>

<script>
import auth from './components/Auth.js'
import Navigation from './components/Navigation'
// import { mapGetters, mapActions } from 'vuex'

export default {
  name: 'app',
  components: { Navigation },
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
#app
  font-family: 'Avenir', Helvetica, Arial, sans-serif
  -webkit-font-smoothing: antialiased
  -moz-osx-font-smoothing: grayscale

.route-enter-active
  transition: all .2s
  opacity: 1

.route-leave-active
  transition: all .2s
  opacity: 0

i.fa.fa-heart
  color: red

figure img
  border-radius: 5px
</style>
