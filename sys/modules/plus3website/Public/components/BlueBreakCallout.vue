<template>
<!-- this is commented out because there seems to be some bug or something
with v-if and nuxt-link where nuxt-link doesn't respoect the conditional?
  <nuxt-link :to="data.link_href" class="banner-cta" v-if="data">
    <span class="banner-cta-content">
      <h2 class="banner-cta-heading">{{data.link_title}} <span class="icon-arrow"></span></h2>
    </span>
  </nuxt-link> -->
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
