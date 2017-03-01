<template lang="pug">
  section.section-module.section-reviews(v-if='data')
    .row
      .xsmall-12.columns
        .review-slideshow
          .review-slide(v-for='testimonial in data.testimonials')
            blockquote.review
              span.icon-quote.open-quote
              div(v-html='testimonial.content')
              cite - {{testimonial.author}}
              span.icon-quote.close-quote
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
      $('.review-slideshow').slick({
      fade:true,
      autoplay:true,
      autoplaySpeed: 4000,
      dots: true,
      infinite: true,
      speed: 1000,
      slidesToShow: 1,
      arrows: false
      });
    }
  }
</script>
