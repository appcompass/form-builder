<template lang="pug">
  footer.footer
    .footer-buttons
      nuxt-link.btn-footer(to='/contact')
        span.icon.icon-contact
        |  Contact Us
      a.btn-footer.btn-proposal(href='#proposal-popup')
        span.icon.icon-document
        |  Request a Proposal
    .footer-bottom
      nuxt-link.footer-logo(to='/')
        span.visually-hidden {{meta.name}}
      nav.footer-nav
        ul
          li(v-for='item in menus.main_footer_menu')
            nuxt-link(:to='item.url') {{item.title}}
      .footer-social
        a(v-if='meta.instagram_url', :href='meta.instagram_url')
          span.icon.icon-instagram
        a(v-if='meta.twitter_url', :href='meta.twitter_url')
          span.icon.icon-twitter
        a(v-if='meta.facebook_url', :href='meta.facebook_url')
          span.icon.icon-facebook
        a(v-if='meta.linkedin_url', :href='meta.linkedin_url')
          span.icon.icon-linkedin
    .footer-copyright
      p &copy;2010-{{ new Date().getFullYear() }} {{meta.name}} All Rights Reserved
</template>

<script>
  export default {
    props: [
      'menus',
      'meta',
      // 'current_url'
    ],
    mounted () {
      $('.btn-proposal').magnificPopup({
        type:'inline',
        closeMarkup:'<button title="%title%" type="button" class="mfp-close icon-close"></button>'
      });
    }
  }
</script>
