<template lang="pug">
  div(v-if='data')
    section.section-project
      .section-project-image(style="background-image:url('assets/images/content/bg_project_atmgurus.jpg');")
      .section-project-content
        .row
          .small-6.columns
            .project-logo
              img(src='assets/images/content/logo_atmgurus.svg', width='457', height='164')
            .project-services
              p
                strong Plus 3 Interactive Services:
              ul
                li Custom Web application
                li Application management system (AMS)
                li Middleware development
            a.btn-white.btn-project(href='#project-name-popup') View Details
    // section-project
    section.section-project
      .section-project-image(style="background-image:url('assets/images/content/bg_project_bostonpads.jpg');")
      .section-project-content
        .row
          .small-6.columns
            .project-logo
              img(src='assets/images/content/logo_bostonpads.svg', width='532', height='56')
            .project-services
              p
                strong Plus 3 Interactive Services:
              ul
                li Custom Web application
                li Application management system (AMS)
                li Middleware development
            a.btn-white.btn-project(href='#project-name-popup') View Details
    // section-project
    section.section-project
      .section-project-image(style="background-image:url('assets/images/content/bg_project_versalink.jpg');")
      .section-project-content
        .row
          .small-6.columns
            .project-logo
              img(src='assets/images/content/logo_versalink.svg', width='393', height='167')
            .project-services
              p
                strong Plus 3 Interactive Services:
              ul
                li Custom Web application
                li Application management system (AMS)
                li Middleware development
            a.btn-white.btn-project(href='#project-name-popup') View Details
    // section-project
    section.section-project
      .section-project-image(style="background-image:url('assets/images/content/bg_project_pronto.jpg');")
      .section-project-content
        .row
          .small-6.columns
            .project-logo
              img(src='assets/images/content/logo_pronto.png', width='249', height='204')
            .project-services
              p
                strong Plus 3 Interactive Services:
              ul
                li Custom Web application
                li Application management system (AMS)
                li Middleware development
            a.btn-white.btn-project(href='#project-name-popup') View Details
    // section-project
    #project-name-popup.popup.popup-project.mfp-hide
      .popup-pad.row
        p.popup-project-logo
          img(src='assets/images/content/logo_versalink_color.svg', width='310', height='128')
        .row
          .medium-8.columns
            h3 Business: Banking Devices
            p
              | VersaLink Communication System is Triton&rsquo;s proprietary application for monitoring data and health of their smart safes and ATMs, via smart phone or computer.
            p
              | We rebuilt VersaLink for efficiency, scalability, performance, and management of multiple devices. We also improved usability while maintaining full compatibility with previous versions. Content TBD
          .medium-4.columns
            h3 Plus 3 Interactive services:
            ul.blue-list
              li
                a(href='') Custom Web application
              li
                a(href='') Middleware development
              li
                a(href='') Device communications
      .popup-footer
        p
          a(href='')
            | For information on how we can help you, please contact us
            span.icon-arrow
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
      $('.project-card').matchHeight();

      if ($(window).width() < breakpoints.small) {
        $('.project-card').matchHeight({ remove: true });
      }

      $('.btn-project').magnificPopup({
        type:'inline',
        closeMarkup:'<button title="%title%" type="button" class="mfp-close icon-close"></button>'
      });

    }
  }
</script>
