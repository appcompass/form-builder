<template lang="pug">
  .section-pad(v-if='data')
    .row
      .medium-8.medium-centered.columns
        form
          .row
            .small-6.columns
              label.inside(for='') *Email
              input(type='email')
            .small-6.columns
              label.inside(for='') *Password
              input(type='text')
          .row
            .small-6.columns
              .checkbox
                input#remember_me(type='checkbox')
                label(for='remember_me') Remember Me
            .small-6.columns.text-right
              .row
                .small-6.columns.text-left
                  a(href='/forgot-password') Forgot Password?
                .small-6.columns.text-right
                  button.btn-blue
                    | Login
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
