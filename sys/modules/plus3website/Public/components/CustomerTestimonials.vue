<template>
    <section class="section-module section-reviews">
        <div class="row">
            <div class="xsmall-12 columns">
                <div class="review-slideshow">
                    <div class="review-slide">
                        <blockquote class="review">
                            <span class="icon-quote open-quote"></span>
                            Plus 3 Interactive helped us build out 2 new sites for our most popular brands, integrated our existing database, and seamlessly migrated over 45,000 products to the new sites.
                            <cite>- Chris Vallely, Christian Brands</cite>
                            <span class="icon-quote close-quote"></span>
                        </blockquote>
                    </div>

                    <div class="review-slide">
                        <blockquote class="review">
                            <span class="icon-quote open-quote"></span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla eget elementum arcu. Donec viverra porttitor blandit. Cras maximus tortor vel tristique fermentum.
                            <cite>- Chris Vallely, Christian Brands</cite>
                            <span class="icon-quote close-quote"></span>
                        </blockquote>
                    </div>

                    <div class="review-slide">
                        <blockquote class="review">
                            <span class="icon-quote open-quote"></span>
                            Cras eu eleifend nibh. Etiam bibendum porta arcu quis venenatis. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            <cite>- Chris Vallely, Christian Brands</cite>
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
