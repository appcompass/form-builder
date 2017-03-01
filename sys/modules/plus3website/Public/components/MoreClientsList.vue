<template lang="pug">
  div(v-if='data')
    .small-6.columns
      .project-card
        p.project-card-image
          img(src='assets/images/content/logo_level_headed.svg', width='205', height='154')
        h2.project-card-type Business: Online Education
        .project-card-desc
          p
            b
              a(href='') Custom Web Application
              |  to demo viability of online student test prep, including practice tests, test results, &amp; analytics. Content TBD
    .small-6.columns
      .project-card
        p.project-card-image
          img(src='assets/images/content/logo_gpg.svg', width='243', height='154')
        h2.project-card-type Business: Online Education
        .project-card-desc
          p
            b
              a(href='') Custom Web Application
              |  and Application Management System for online Akkadian language class - student registration, data, resources, &amp; Webex participation.
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
