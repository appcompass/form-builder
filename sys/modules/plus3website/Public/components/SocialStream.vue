<template>
  <section v-if="data" class="section-module section-social">
    <div class="row">
      <div class="xsmall-12 columns">
        <div class="section-header">
          <h2 class="section-heading" v-html="data.title"></h2>
          <div class="section-social-follow">
            <span>Follow Us</span> <a class="icon-instagram" :href="data.site_instagram"></a> <a class="icon-twitter" :href="data.site_twitter"></a> <a class="icon-facebook" :href="data.site_facebook"></a>
          </div>
        </div>
      </div>
    </div>
    <div class="facebook-slideshow-wrap">

      <div class="facebook-slideshow">
        <div class="facebook-slide" v-for="feed in data.facebook_feed">
          <div class="fb-header">
            <div class="fb-avatar"><img :src="feed.page_picture"></div>
            <h3 class="fb-user"><a :href="data.site_facebook">{{feed.page_name}}</a></h3>
            <div class="fb-followers">{{feed.page_follower_count}} followers</div>
            <a :href="feed.page_link" class="fb-icon icon-facebook-square"></a>
          </div>
          <div class="fb-post">
            <span class="fb-post-img"><img :src="feed.post_image"></span>
            <h2 class="fb-post-title">{{feed.post_title}}</h2>
            <p class="fb-post-desc">{{feed.post_content}}</p>
          </div>
          <div class="fb-footer">
            <a>Like</a> <!-- not sure we can make a regular link initiate a like? -->
            <a>Comment</a> <!-- Modal? -->
            <a>Share</a> <!-- easy one, but we can put that in later -->
            <span class="fb-likes">{{feed.like_count}} people like this</span>
          </div>
        </div>
      </div><!-- facebook-slideshow -->
      <div class="facebook-slideshow-controls"></div>
    </div><!-- facebook-slideshow-wrap -->
  </section><!-- section-social -->
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
      $('.facebook-slide').matchHeight();

      if ($(window).width() < breakpoints.small) {
        $('.facebook-slide').matchHeight({ remove: true });
      }

      $('.facebook-slideshow').slick({
        centerMode: true,
        centerPadding: '20px',
        infinite:false,
        speed: 300,
        arrows: false,
        mobileFirst: true,
        responsive: [
          {
            breakpoint: breakpoints.xsmall,
            settings: {
              variableWidth: true,
              centerMode: false,
            }
          },{
            breakpoint: breakpoints.medium - 1,
            settings: {
              variableWidth: true,
              centerMode: false,
              arrows: true,
              appendArrows: '.facebook-slideshow-controls',
              prevArrow: '<button type="button" class="slick-prev"><span class="icon-arrow"></span></button>',
              nextArrow: '<button type="button" class="slick-next"><span class="icon-arrow"></span></button>',
            }
          }
        ]
      });
    }
  }
</script>
