<template lang="pug">
  div(v-if='data')
    .small-6.columns(v-for='box in data.boxes')
      nuxt-link.solution-box(:to='box.link_href')
        span.solution-box-front
          span.solution-box-icon
            img(:src='box.image', :width='box.image_width', :height='box.image_height')
          |
          span.solution-box-title {{box.title}}
        |
        span.solution-box-back
          span.solution-box-back-center
            span.solution-box-title {{box.title}}
            |
            ul.solution-box-list
              li(v-for='point in box.points') {{point}}
            |
            span.solution-box-more
              span.icon-plus
              |  {{box.link_text}}
</template>

<script>
  export default {
  props: ['data'],
  mounted () {
    $('.solution-box').matchHeight();
    $('.solution-box-front').matchHeight();

    if ($(window).width() < breakpoints.small) {
      $('.solution-box, .solution-box-front').matchHeight({ remove: true });
    }
  }
  }
</script>
