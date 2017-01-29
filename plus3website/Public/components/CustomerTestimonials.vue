<template>
  <section v-if="data" class="section-module section-reviews">
    <div class="row">
      <div class="xsmall-12 columns">
        <div class="review-slideshow">
          <div class="review-slide" v-for="testimonial in data.testimonials">
            <blockquote class="review">
              <span class="icon-quote open-quote"></span>
              <div v-html="testimonial.content"></div>
              <cite>- {{testimonial.author}}</cite>
              <span class="icon-quote close-quote"></span>
            </blockquote>
          </div>
        </div>
      </div>
    </div>
  </section>
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
