<template lang="pug">
  section.section-module.section-social(v-if='data')
    .row
      .xsmall-12.columns
        .section-header
          h2.section-heading(v-html='data.title')
          .section-social-follow
            span Follow Us
            a.icon-instagram(:href='data.site_instagram')
            a.icon-twitter(:href='data.site_twitter')
            a.icon-facebook(:href='data.site_facebook')
    .facebook-slideshow-wrap
      .facebook-slideshow
        .facebook-slide(v-for='feed in fb.feed')
          .fb-header
            .fb-avatar
              img(:src='fb.picture')
            h3.fb-user
              a(:href='data.site_facebook') {{fb.name}}
            .fb-followers {{fb.fan_count}} followers
            a.fb-icon.icon-facebook-square(:href='feed.page_link', target='_blank')
          .fb-post
            span.fb-post-img
              img(:src='feed.full_picture')
            h2.fb-post-title {{feed.message}}
            p.fb-post-desc {{feed.description}}
          .fb-footer
            a(v-for='action in feed.actions', :href='action.link', target='_blank') {{action.name}}
            span.fb-likes {{feed.reactions}} people like this
      .facebook-slideshow-controls
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
