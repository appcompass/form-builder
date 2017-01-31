<template>
  <div v-if="data">
    <section class="section-solution">
      <div class="row">
        <div class="medium-12 columns" v-html="data.content">
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
