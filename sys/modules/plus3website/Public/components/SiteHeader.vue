<template>
  <header class="header">
    <div class="logo-wrap">
      <nuxt-link to="/" class="logo"><span class="visually-hidden">{{meta.name}}</span></nuxt-link>
      <a class="main-nav-trigger"><span></span></a>
    </div>
    <nav class="main-nav">
      <ul>
        <li :class="{ 'current-menu-item': is_in_current(item)}" v-for="item in menus.main_header_menu">
          <nuxt-link :to="item.url"><span class="icon" :class="item.icon"></span> {{item.title}} <span class="nav-dropdown-arrow" v-if="item.children.length"></span></nuxt-link>
          <ul v-if="item.children.length">
            <li v-for="sub in item.children"><nuxt-link :to="sub.url"><span class="icon" :class="item.icon"></span> {{sub.title}}</nuxt-link></li>
          </ul>
        </li>
      </ul>
      <div class="main-nav-social">
        Follow Us
        <a v-if="meta.instagram_url" :href="meta.instagram_url"><span class="icon icon-instagram"></span></a>
        <a v-if="meta.twitter_url" :href="meta.twitter_url"><span class="icon icon-twitter"></span></a>
        <a v-if="meta.facebook_url" :href="meta.facebook_url"><span class="icon icon-facebook"></span></a>
        <a v-if="meta.linkedin_url" :href="meta.linkedin_url"><span class="icon icon-linkedin"></span></a>
      </div>
    </nav>
  </header><!-- header -->

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
