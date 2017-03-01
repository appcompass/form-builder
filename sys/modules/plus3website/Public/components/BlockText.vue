<template lang="pug">
  div(v-if='data')
    section.section-solution
      .row
        .medium-12.columns(v-html='data.content')
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
