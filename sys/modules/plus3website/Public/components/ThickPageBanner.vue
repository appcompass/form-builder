<template lang="pug">
  .banner(v-if='data', :style="{backgroundImage: 'url(' + data.banner_image + ')' }")
    .banner-content
      .row
        .medium-8.medium-centered.columns
          h1.banner-title {{ data.title }}
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
