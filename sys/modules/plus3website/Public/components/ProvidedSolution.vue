<template lang="pug">
  div(v-if='data')
    section.section-solution(v-for='row in data.solutions')
      .row
        .medium-6.columns.medium-text-center(:class=" row.layout == 'left' ? 'medium-push-6' : ''")
          p.solution-graphic
            img(:src='row.solution_photo', :width='row.photo_width', :height='row.photo_height')
        .medium-6.columns(:class=" row.layout == 'left' ? 'medium-pull-6' : ''")
          h2 {{row.title}}
          div(v-html='row.description')
          ul.blue-list
            li(v-for='project in row.projects_using_solution')
              nuxt-link(:to='project.href') {{project.text}}
          hr
          h3 {{row.link_description}}
          p
            nuxt-link.btn-blue(:to='row.link_href')
              | {{row.link_title}}
              span.icon-arrow
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
