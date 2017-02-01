<template lang="pug">
  .section-breadcrumb(v-if='data')
    .row
      .small-6.columns
        // @TODO: this needs to be dynamic
        p.breadcrumb
          a(href='') Solutions
          span.sep /
          |  Our Process
      .small-6.columns.small-text-right
        p
          nuxt-link(:to='data.link_href')
            | {{data.link_title}}
            span.icon-arrow
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
