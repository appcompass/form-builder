<template id="SliderBanner">
    <section class="home-banner">
        <div class="home-banner-header">
            <div class="home-banner-header-container">
                <h1 class="home-banner-heading">Our Work</h1>
            </div>
        </div>
        <div class="work-slideshow">
            <article class="work-slide">
                <div class="work-slide-container">
                    <div class="work-slide-image"><img src="assets/images/content/slide_atmgurus.png"></div>
                    <div class="work-slide-content">
                        <h2 class="work-slide-title">ATM Gurus</h2>
                        <div class="work-slide-desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis tortor lobortis, ultrices risus ac.</p>
                        </div>
                        <a href="" class="work-slide-btn"><span class="icon-plus"></span> See More</a>
                    </div>
                </div>
            </article>
            <article class="work-slide">
                <div class="work-slide-container">
                    <div class="work-slide-image"><img src="assets/images/content/slide_atmgurus.png"></div>
                    <div class="work-slide-content">
                        <h2 class="work-slide-title">ATM Gurus</h2>
                        <div class="work-slide-desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse quis tortor lobortis, ultrices risus ac.</p>
                        </div>
                        <a href="" class="work-slide-btn"><span class="icon-plus"></span> See More</a>
                    </div>
                </div>
            </article>
        </div>
    </section><!-- home-banner -->
</template>

<script>
  export default {
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
