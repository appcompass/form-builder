<template lang="pug">
  #proposal-popup.popup.popup-proposal.mfp-hide(v-if='data')
    .row
      .xsmall-12.columns
        h1 Request for Proposal
        form
          .row
            .small-6.columns
              label.inside(for='') *First Name
              input(type='text')
            .small-6.columns
              label.inside(for='') *Last Name
              input(type='text')
          .row
            .small-6.columns
              label.inside(for='') *Email
              input(type='text')
            .small-6.columns
              label.inside(for='') *Phone Number
              input(type='text')
          .row
            .small-6.columns
              label.inside(for='') *Company
              input(type='text')
            .small-6.columns
              label.inside(for='') *Company Website
              input(type='text')
          .row
            .small-12.columns
              label.inside(for='') *Describe the size, domain, focus, and customers of your business:
              textarea(rows='8')
          .row
            .small-12.columns
              label.inside(for='') Describe the project for which you are requesting a proposal from us:
              textarea(rows='8')
          .row
            .small-12.columns
              label.inside(for='') Describe the purpose of your proposed project:
              textarea(rows='8')
          .row
            .small-12.columns
              p Check one or more services you&rsquo;ll likely require for your project:
              .checkbox
                input#web-application-development(type='checkbox')
                label(for='web-application-development') Web application development
              .checkbox
                input#middleware-development(type='checkbox')
                label(for='middleware-development') Middleware development
              .checkbox
                input#device-communications(type='checkbox')
                label(for='device-communications') Device communications
              .checkbox
                input#custom-application-management-system(type='checkbox')
                label(for='custom-application-management-system') Custom application management system
              .checkbox
                input#other.checkbox-reveal(type='checkbox')
                label(for='other') Other
              .hide
                label.inside(for='') Specify
                input(type='text')
          .row
            .small-12.columns
              label.inside(for='') Optionally, provide other information you&rsquo;d like us to know.
              textarea(rows='8')
          .form-footer
            .row
              .small-8.columns
                p.required-notice Before submitting the RFP you must complete all * fields above.
              .small-4.columns.small-text-right
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
