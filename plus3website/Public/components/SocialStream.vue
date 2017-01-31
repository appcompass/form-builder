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
        <div class="facebook-slide" v-for="feed in fb.feed">
          <div class="fb-header">
            <div class="fb-avatar"><img :src="fb.picture"></div>
            <h3 class="fb-user"><a :href="data.site_facebook">{{fb.name}}</a></h3>
            <div class="fb-followers">{{fb.fan_count}} followers</div>
            <a :href="feed.page_link" class="fb-icon icon-facebook-square" target="_blank"></a>
          </div>
          <div class="fb-post">
            <span class="fb-post-img"><img :src="feed.full_picture"></span>
            <h2 class="fb-post-title">{{feed.message}}</h2>
            <p class="fb-post-desc">{{feed.description}}</p>
          </div>
          <div class="fb-footer">
            <a v-for="action in feed.actions" :href="action.link" target="_blank">{{action.name}}</a>
            <span class="fb-likes">{{feed.reactions}} people like this</span>
          </div>
        </div>
      </div>
      <div class="facebook-slideshow-controls"></div>
    </div>
  </section>
</template>

<script>
  import axios from 'axios'

  export default {
    props: ['data'],
    data () {
      return {
        fb: {}
      }
    },
    methods: {
    },
    created () {
      axios.get(`https://www.plus3interactive.com/api/facebook/feed`)
      .then((res) => {
        this.fb = res.data
      }).catch((e) => {
        console.log(e.message);
        return { statusCode: 404, message: e.message }
      })
    },
    mounted () {
    },
    updated () {
        $('.facebook-slide').matchHeight({byRow:false});

        if ($(window).width() < breakpoints.small) {
          $('.facebook-slide').matchHeight({remove: true});
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
<style>
  .fb-post-img img {
    max-height:280px;
  }
</style>
