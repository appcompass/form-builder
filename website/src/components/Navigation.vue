<template lang="jade">

//- Main Nav
nav.main-nav
  ul
    li(v-for="item in navigation")
      router-link(v-bind:to="item.to")
        span.icon(v-bind:class='"icon-" + item.icon')
        |  {{ item.label }}

  //- Socials
  .main-nav-social Follow Us
    a(href="#")
      span.icon.icon-instagram
    a(href="#")
      span.icon.icon-twitter
    a(href="#")
      span.icon.icon-facebook

</template>

<script>
// import Vue from 'vue'

export default {
  name: 'Navigation',
  data () {
    return {
      // navigation: Object.create({})
      navigation: [
        {'label': 'Solutions', 'icon': 'solutions', 'to': '/solutions'},
        {'label': 'Projects', 'icon': 'projects', 'to': '/projects'},
        {'label': 'Company', 'icon': 'company', 'to': '/company'},
        {'label': 'Contact Us', 'icon': 'contact', 'to': '/contact-us'}
      ]
    }
  },
  beforeCreate () {
    // Vue.http.get('https://api.k1cc0.me/api/navigation?api_token=313')
    //   .then(function (response) {
    //     this.navigation = response.body
    //   }.bind(this))
    //   .catch(function (err) {
    //     console.error(err)
    //   })
  }
}
</script>

<style lang="sass">
@import '../assets/sass/_settings.scss'

.router-link-active
  border-top-color: $blue !important
</style>
