<template lang="jade">

  footer.footer
    //- Footer Buttons
    .footer-buttons
      a.btn-footer(href="")
        span.icon.icon-contact Contact Us

      a.btn-footer.btn-proposal(@click="$emit('open', {type: 'Proposal', active: true})")
        span.icon.icon-document Request a Proposal

    //- Footer Logo and Mavmenu
    .footer-bottom

      router-link.footer-logo(:to="'/'")
        span.visually-hidden Plus 3 Interactive

      nav.footer-nav
        ul
          li(v-for="item in footerNav")
            router-link.special(:to="item.to") {{ item.label }}

      //- Social Neworks Links
      .footer-social
        a(href="#")
          span.icon.icon-instagram

        a(href="#")
          span.icon.icon-twitter

        a(href="#")
          span.icon.icon-facebook

    //- Footer Copyright
    .footer-copyright
      p &copy;2010-{{ new Date().getFullYear() }} Plus 3 Interactive LLC All Rights Reserved

</template>

<script>
  import Vue from 'vue'
  import Modal from './Modal'

  export default {
    name: 'Footer',
    data () {
      return {
        Modal: Modal,
        footerNav: Object.create({}),
        currentYear: new Date().getFullYear('Y')
      }
    },
    mounted () {
      // console.log(this.Modal)
    },
    // @TODO this is obviously redundant and we should have this fetched at app level
    beforeCreate () {
      Vue.http.get('https://api.k1cc0.me/api/navigation?api_token=313')
        .then(function (response) {
          this.footerNav = response.body
        }.bind(this))
        .catch(function (err) {
          console.error(err)
        })
    }
  }
</script>

<style lang="sass" scoped>
  @import '../assets/sass/_settings.scss'

  .router-link-active
    color: $blue
</style>
