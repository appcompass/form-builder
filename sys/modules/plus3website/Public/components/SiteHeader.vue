<template lang="pug">
  header.header
    .logo-wrap
      nuxt-link.logo(to='/')
        span.visually-hidden {{meta.name}}
      a.main-nav-trigger
        span
    nav.main-nav
      ul
        li(:class="{ 'current-menu-item': is_in_current(item)}", v-for='item in menus.main_header_menu')
          nuxt-link(:to='item.url')
            span.icon(:class='item.icon')
            |  {{item.title}}
            span.nav-dropdown-arrow(v-if='item.children.length')
          ul(v-if='item.children.length')
            li(v-for='sub in item.children')
              nuxt-link(:to='sub.url')
                span.icon(:class='item.icon')
                |  {{sub.title}}
      .main-nav-social
        | Follow Us
        a(v-if='meta.instagram_url', :href='meta.instagram_url')
          span.icon.icon-instagram
        a(v-if='meta.twitter_url', :href='meta.twitter_url')
          span.icon.icon-twitter
        a(v-if='meta.facebook_url', :href='meta.facebook_url')
          span.icon.icon-facebook
        a(v-if='meta.linkedin_url', :href='meta.linkedin_url')
          span.icon.icon-linkedin
</template>

<script>
  export default {
    props: ['menus', 'meta', 'current_url'],
    mounted () {
      $('.main-nav-trigger').on('click', function() {
        $(this).toggleClass('is-open');
        $('.main-nav').toggleClass('is-open');
      });

      $('.nav-dropdown-arrow').on('click', function(e) {
        e.preventDefault();
        $(this).parent().parent().toggleClass('is-open');
      });
    },
    methods: {
      is_in_current (item) {
        return this.current_url.indexOf(item.url) >= 0
      }
    }
  }
</script>
