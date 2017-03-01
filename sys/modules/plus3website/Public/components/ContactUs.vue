<template lang="pug">
  .section-pad(v-if='data')
    .row
      .medium-8.medium-centered.columns
        form
          .row
            .small-6.columns
              label.inside(for='') *First Name
              input(type='text' value='')
            .small-6.columns
              label.inside(for='') *Last Name
              input(type='text')
          .row
            .small-6.columns
              label.inside(for='') *Email
              input(type='email')
            .small-6.columns
              label.inside(for='') *Phone
              input(type='text')
          .row
            .small-6.columns
              label.inside(for='') *Company Name
              input(type='text')
            .small-6.columns
              label.inside(for='') *Company Website
              input(type='text')
          .row
            .small-12.columns
              label.inside(for='') *Your Message
              textarea(rows='8')
          .row
            .small-12.columns.text-right
              button.btn-blue
                | Send
                span.icon-arrow
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
      FormsJquery.init();
    }
  }
</script>
