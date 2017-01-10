<template lang="jade">
.row
  .xsmall-12.columns
    h1 Request for Proposal
    form
      .row
        .small-6.columns
          label.inside *First Name
          input(type="text", v-model="form.first_name")
        .small-6.columns
          label.inside *Last Name
          input(type="text", v-model="form.last_name")

      .row
        .small-6.columns
          label.inside *Email
          input(type="text", v-model="form.email")
        .small-6.columns
          label.inside *Phone Number
          input(type="text", v-model="form.phone")

      .row
        .small-6.columns
          label.inside *Company
          input(type="text", v-model="form.company")
        .small-6.columns
          label.inside *Company Website
          input(type="text", v-model="form.company_website")

      .row
        .small-12.columns
          label.inside *Describe the size, domain, focus and customers of your business:
          textarea(rows="8", v-model="form.description")

      .row
        .small-12.columns
          label Describe the purpose of your proposed project:
          textarea(rows="8", v-model="form.purpose")

      .row
        .small-12.columns
          p Check one or more services you’ll likely require for your project:
          .checkbox
            input#middleware(
              type="checkbox"
              v-model="form.services_requested"
              value="middleware"
            )
            label(for="middleware") Middleware development

          .checkbox
            input#device_communications(
              type="checkbox"
              v-model="form.services_requested"
              value="device_communications"
            )
            label(for="device_communications") Device communications

          .checkbox
            input#cms(
              type="checkbox"
              v-model="form.services_requested"
              value="cms"
            )
            label(for="cms") Custom application management system

          .checkbox
            input#other.other.checkbox-reveal(
              type="checkbox"
              v-model="form.other_services"
              value="other"
            )
            label(for="other") Other

          .hidden(v-if="form.other_services.indexOf('other') > -1")
            label.inside *Specify
            input(
              type="text",
              v-model="form.other_services_description"
            )

          .row
            .small-12.columns
              label.inside Optionally, provide other information you’d like us to know.
              textarea(rows="8", v-model="form.other_services_requested")

          .form-footer
            .row
              .small-8.columns
                p.required-notice Before submitting the RFP you must complete all * fields above.
              .small-4.columns.small-text-right
                button.btn-blue Send
                  span.icon-arrow
</template>

<script>
import $ from 'jquery'

export default {
  name: 'Proposal',
  data () {
    return {
      form: {
        other_services: []
      }
    }
  },
  mounted () {
    $('.inside + input:not(:checkbox, :radio), .inside + textarea').on('focus', function () {
      $(this).prev('.inside').removeClass('inside').addClass('outside')
    }).on('focusout', function () {
      if (!$(this).val()) {
        $(this).prev('.outside').removeClass('outside').addClass('inside')
      }
    })
  }
}
</script>
