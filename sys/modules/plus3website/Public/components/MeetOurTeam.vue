<template lang="pug">
  div(v-if='data')
    section.section-module.section-team
      .row
        .medium-8.medium-centered.columns
          .section-header
            h2.section-heading {{data.title}}
            .section-desc(v-if="data.description || data.link_href")
              div(v-html='data.description')
              p(v-if="data.link_text")
                nuxt-link(:to='data.link_href')
                  | {{data.link_text}}
                  span.icon-arrow
      .section-team-members
        //
          @TODO: make /company page dynamic so it can render a page via /company/:person_slug
          and Nuxt handles the rest from there (basically).  On normal click the modal shows up
          but the href (for SOE) is shown as the url link so each person has their own page.
        a.section-team-member.team-popup(:href='member.slug', v-bind:data-mfp-src="modalUrl(member.slug)", v-for='member in data.team', :style="{backgroundImage: 'url(' + member.cover_photo + ')' }")
          span.team-hover
            span.team-name {{member.full_name}}
            span.team-position {{member.title}}
    .popup.popup-team.mfp-hide(:id='member.slug', v-for='member in data.team')
      .row
        .small-4.columns
          p
            img(:src='member.full_photo', width='316', height='432')
        .small-8.columns
          h1 {{member.full_name}}
          span(v-html='member.bio')
          p
            a.team-social(v-if="member.instagram", :href='member.instagram', target='_blank')
              span.icon-instagram
            a.team-social(v-if="member.twitter", :href='member.twitter', target='_blank')
              span.icon-twitter
            a.team-social(v-if="member.facebook", :href='member.facebook', target='_blank')
              span.icon-facebook
            a.team-social(v-if="member.linkedin", :href='member.linkedin', target='_blank')
              span.icon-linkedin
</template>

<script>
// we need to figure out a way to get this info injected into the parent page header
// when the person's modal is active and/or when you go to say /company/imene-saidi
// which should be the modal URL so really any page would trigger it's own implementation of
// the open graph tags if we have them configured for open graph.  i.e. some things
// like blog posts, product pages, etc whill have their own implementation of various tags.
//
// <!-- Schema.org markup for Google+ -->
// <meta itemprop="name" :content="member.full_url">
// <meta itemprop="description" :content="member.bio_summary">
// <meta itemprop="image" :content="member.full_photo">
//
// <!-- Twitter Card data -->
// <meta name="twitter:url" :content="member.full_url">
// <meta name="twitter:card" content="summary" />
// <meta name="twitter:site" :content="member.twitter" />
// <meta name="twitter:title" :content="member.full_name" />
// <meta name="twitter:description" :content="member.bio_summary" />
// <meta name="twitter:image" content="member.full_photo" />
// <meta name="twitter:image:alt" content="member.full_name" />

// <!-- Open Graph data -->
// <meta property="og:title" :content="member.full_name" />
// <meta property="og:type" content="profile" />
// <meta property="og:url" :content="member.full_url" />
// <meta property="og:image" :content="member.full_photo" />
// <meta property="og:description" :content="member.bio_summary" />
//
  export default {
    props: ['data'],
    mounted () {
      $('.team-popup').magnificPopup({
        type: 'inline',
        closeMarkup:'<button title="%title%" type="button" class="mfp-close icon-close"></button>'
      });
    },
    methods: {
      modalUrl (path) {
        return '#' + path.replace(/^\//, '')
      }
    }
  }
</script>
