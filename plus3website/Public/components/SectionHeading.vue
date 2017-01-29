<template>
  <div v-if="data" class="row">
    <div class="medium-8 medium-centered columns">
      <div class="section-header">
        <h2 class="section-heading">{{data.title}}</h2>
        <div class="section-desc" v-html="data.description"></div>
      </div>
    </div>
  </div>
</template>


<script>
  export default {
  props: ['data'],
  mounted () {
  }
  }
</script>
