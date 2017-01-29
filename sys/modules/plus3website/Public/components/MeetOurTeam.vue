<template>
  <div v-if="data">
    <section class="section-module section-team">
      <div class="row">
        <div class="medium-8 medium-centered columns">
          <div class="section-header">
            <h2 class="section-heading">{{data.title}}</h2>
            <div class="section-desc">
              <div v-html="data.description"></div>
              <p><nuxt-link :to="data.link_href">{{data.link_text}} <span class="icon-arrow"></span></nuxt-link></p>
            </div>
          </div>
        </div>
      </div>
      <!-- @TODO: create a component for Plus3Person Model that this data is provided from -->
      <div class="section-team-members">
        <!-- this needs to update the url to /company#imene-saidi but shoudln't change urls,
        on hard refresh it would take the user to that page.  This is basically a
        modal that has the link of the other page, so this is obviously different
        from other situations, but there are a few of these modals we need to do
        this behavior for so def something to abstract and nuxt-link is prob not
        what we want to use here -->
        <nuxt-link :to="member.url" v-for="member in data.team" class="section-team-member team-popup" :style="{backgroundImage: 'url(' + member.cover_photo + ')' }">
          <span class="team-hover">
            <span class="team-name">{{member.full_name}}</span>
            <span class="team-position">{{member.title}}</span>
          </span>
        </a>
      </div>
    </section><!-- section-team -->
    <div :id="member.url" v-for="member in data.team" class="popup popup-team mfp-hide">
      <div class="row">
        <div class="small-4 columns">
          <p><img :src="member.modal_photo" width="316" height="432"></p>
        </div>
        <div class="small-8 columns">
          <h1>{{member.full_name}}</h1>
          <span v-html="member.bio"></p>
          <p>
            <a :href="member.instagram" target="_blank" class="team-social"><span class="icon-instagram"></span></a>
            <a :href="member.twitter" target="_blank" class="team-social"><span class="icon-twitter"></span></a>
            <a :href="member.facebook" target="_blank" class="team-social"><span class="icon-facebook"></span></a>
            <a :href="member.linkedin" target="_blank" class="team-social"><span class="icon-linkedin"></span></a>
          </p>
        </div>
      </div>
    </div> <!-- popup-team -->
  </div>
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
// <meta itemprop="image" :content="member.modal_photo">
//
// <!-- Twitter Card data -->
// <meta name="twitter:url" :content="member.full_url">
// <meta name="twitter:card" content="summary" />
// <meta name="twitter:site" :content="member.twitter" />
// <meta name="twitter:title" :content="member.full_name" />
// <meta name="twitter:description" :content="member.bio_summary" />
// <meta name="twitter:image" content="member.modal_photo" />
// <meta name="twitter:image:alt" content="member.full_name" />

// <!-- Open Graph data -->
// <meta property="og:title" :content="member.full_name" />
// <meta property="og:type" content="profile" />
// <meta property="og:url" :content="member.full_url" />
// <meta property="og:image" :content="member.modal_photo" />
// <meta property="og:description" :content="member.bio_summary" />
//
  export default {
  props: ['data'],
  mounted () {
    $('.team-popup').magnificPopup({
    type:'inline',
    closeMarkup:'<button title="%title%" type="button" class="mfp-close icon-close"></button>'
    });
  }
  }
</script>
