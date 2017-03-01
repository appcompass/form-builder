<template lang="pug">
  section.banner-blue(v-if='data')
    .row
      .xsmall-12.columns
        .banner-blue-container
          .banner-blue-icon
            img(:src='data.image', :width='data.image_width', :height='data.image_height')
          .banner-blue-content
            h2.banner-blue-heading {{data.title}}
            div(v-html='data.description')
            nuxt-link.btn-white(:to='data.link_href')
              | {{data.link_title}}
              span.icon-arrow
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
