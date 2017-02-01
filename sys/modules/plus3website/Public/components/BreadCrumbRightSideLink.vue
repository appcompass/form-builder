<template>
  <div v-if="data" class="section-breadcrumb">
    <div class="row">
      <div class="small-6 columns">
        <!-- @TODO: this needs to be dynamic -->
        <p class="breadcrumb"><a href="">Solutions</a> <span class="sep">/</span> Our Process</p>
      </div>
      <div class="small-6 columns small-text-right">
        <p><nuxt-link :to="data.link_href">{{data.link_title}} <span class="icon-arrow"></span></nuxt-link></p>
      </div>
    </div>
  </div><!-- section-breadcrumb -->
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
