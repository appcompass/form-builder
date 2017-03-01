<template lang="pug">
  .row(v-if='data')
    .medium-8.medium-centered.columns
      .section-header
        h2.section-heading {{data.title}}
        .section-desc(v-html='data.description')
</template>


<script>
  export default {
  props: ['data'],
  mounted () {
  }
  }
</script>
