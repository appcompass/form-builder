<template lang="pug">
  .section-solution.solution-intro(v-if='data')
    .row
      .medium-8.medium-centered.columns
        h1 {{data.title}}
        div(v-html='data.description')
        ul.blue-list.list-centered(v-if="data.link_format == 'ul'")
          li(v-for='link in data.links')
            nuxt-link(:to='link.href') {{link.text}}
        ol.blue-list.list-centered(v-if="data.link_format == 'ol'")
          li(v-for='link in data.links')
            nuxt-link(:to='link.href') {{link.text}}
        div(v-if="data.link_format == 'arrow'")
          nuxt-link(:to='link.href', v-for='link in data.links')
            | {{link.text}}
            span.icon-arrow
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
