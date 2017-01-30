<template>
  <div v-if="data" class="banner" :style="{backgroundImage: 'url(' + data.banner_image + ')' }">
    <div class="banner-content">
      <div class="row">
        <div class="medium-8 medium-centered columns">
          <h1 class="banner-title">{{ data.title }}</h1>
        </div>
      </div>
    </div>
  </div><!-- banner -->
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
