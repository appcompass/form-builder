<template>
  <div v-if="data">
    <div class="small-6 columns" v-for="box in data.boxes">
      <nuxt-link :to="box.link_href" class="solution-box">
        <span class="solution-box-front">
          <span class="solution-box-icon"><img :src="box.image" :width="box.image_width" :height="box.image_height"></span>
          <span class="solution-box-title">{{box.title}}</span>
        </span>
        <span class="solution-box-back">
          <span class="solution-box-back-center">
            <span class="solution-box-title">{{box.title}}</span>
            <ul class="solution-box-list">
              <li v-for="point in box.points">{{point}}</li>
            </ul>
            <span class="solution-box-more"><span class="icon-plus"></span> {{box.link_text}}</span>
          </span>
        </span>
      </nuxt-link>
    </div>
  </div>
</template>

<script>
  export default {
  props: ['data'],
  mounted () {
    $('.solution-box').matchHeight();
    $('.solution-box-front').matchHeight();

    if ($(window).width() < breakpoints.small) {
      $('.solution-box, .solution-box-front').matchHeight({ remove: true });
    }
  }
  }
</script>
