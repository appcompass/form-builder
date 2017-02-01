<template lang="pug">
  section.home-banner(v-if='data')
    .home-banner-header
      .home-banner-header-container
        h1.home-banner-heading {{ data.title }}
    .work-slideshow
      article.work-slide(v-for='slide in data.slides', :style="{backgroundImage: 'url(' + slide.banner_image + ')' }")
        .work-slide-container
          .work-slide-content
            h2.work-slide-title {{slide.title}}
            .work-slide-desc(v-html='slide.description')
            nuxt-link.work-slide-btn(:to='slide.link_href')
              span.icon-plus
              |  {{slide.link_text}}
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
      $('.work-slideshow').slick({
        dots: true,
        autoplay:true,
        autoplaySpeed: 5000,
        infinite: true,
        speed: 1000,
        slidesToShow: 1,
        arrows: false,
        mobileFirst: true,
        customPaging : function(slider, i) {
          var num = i + 1;
          return '<button type="button" data-role="none" role="button" tabindex="0">0'+ num + '</button>';
        },
      });
    }
  }
</script>

<style>
  h1.home-banner-heading {
    z-index: 1;
  }
  article.work-slide {
    background-repeat: no-repeat;
    background-position: center right;
    background-size: cover;
  }
</style>
