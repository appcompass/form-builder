<template>
  <footer class="footer">
    <div class="footer-buttons">
      <nuxt-link to="/contact" class="btn-footer"><span class="icon icon-contact"></span> Contact Us</nuxt-link>
      <a href="#proposal-popup" class="btn-footer btn-proposal"><span class="icon icon-document"></span> Request a Proposal</a>
    </div>
    <div class="footer-bottom">
      <nuxt-link to="/" class="footer-logo"><span class="visually-hidden">{{meta.name}}</span></nuxt-link>
      <nav class="footer-nav">
        <ul>
          <li v-for="item in menus.main_footer_menu">
            <nuxt-link :to="item.url">{{item.title}}</nuxt-link>
          </li>
        </ul>
      </nav>
      <div class="footer-social">
        <a v-if="meta.instagram_url" :href="meta.instagram_url"><span class="icon icon-instagram"></span></a>
        <a v-if="meta.twitter_url" :href="meta.twitter_url"><span class="icon icon-twitter"></span></a>
        <a v-if="meta.facebook_url" :href="meta.facebook_url"><span class="icon icon-facebook"></span></a>
        <a v-if="meta.linkedin_url" :href="meta.linkedin_url"><span class="icon icon-linkedin"></span></a>
      </div>
    </div>
    <div class="footer-copyright">
      <p>&copy;2010-{{ new Date().getFullYear() }} {{meta.name}} All Rights Reserved</p>
    </div>
  </footer><!-- footer -->

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
