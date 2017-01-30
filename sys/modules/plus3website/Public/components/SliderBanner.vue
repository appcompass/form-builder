<template>
  <section v-if="data" class="home-banner">
    <div class="home-banner-header">
      <div class="home-banner-header-container">
        <h1 class="home-banner-heading">{{ data.title }}</h1>
      </div>
    </div>
    <div class="work-slideshow">
      <article class="work-slide" v-for="slide in data.slides" :style="{backgroundImage: 'url(' + slide.banner_image + ')' }">
        <div class="work-slide-container">
          <div class="work-slide-content">
            <h2 class="work-slide-title">{{slide.title}}</h2>
            <div class="work-slide-desc" v-html="slide.description"></div>
            <nuxt-link :to="slide.link_href" class="work-slide-btn"><span class="icon-plus"></span> {{slide.link_text}}</nuxt-link>
          </div>
        </div>
      </article>
    </div>
  </section><!-- home-banner -->
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
      $('.work-slideshow').slick({
        dots: true,
        infinite: true,
        speed: 300,
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
