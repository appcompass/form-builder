<template>
  <div v-if="data">
    <section class="section-project">
      <div class="section-project-image" style="background-image:url('assets/images/content/bg_project_atmgurus.jpg');"></div>
      <div class="section-project-content">
        <div class="row">
          <div class="small-6 columns">
            <div class="project-logo"><img src="assets/images/content/logo_atmgurus.svg" width="457" height="164"></div>
            <div class="project-services">
              <p><strong>Plus 3 Interactive Services:</strong></p>
              <ul>
                <li>Custom Web application</li>
                <li>Application management system (AMS)</li>
                <li>Middleware development</li>
              </ul>
            </div>
            <a href="#project-name-popup" class="btn-white btn-project">View Details</a>
          </div>
        </div>
      </div>
    </section><!-- section-project -->

    <section class="section-project">
      <div class="section-project-image" style="background-image:url('assets/images/content/bg_project_bostonpads.jpg');"></div>
      <div class="section-project-content">
        <div class="row">
          <div class="small-6 columns">
            <div class="project-logo"><img src="assets/images/content/logo_bostonpads.svg" width="532" height="56"></div>
            <div class="project-services">
              <p><strong>Plus 3 Interactive Services:</strong></p>
              <ul>
                <li>Custom Web application</li>
                <li>Application management system (AMS)</li>
                <li>Middleware development</li>
              </ul>
            </div>
            <a href="#project-name-popup" class="btn-white btn-project">View Details</a>
          </div>
        </div>
      </div>
    </section><!-- section-project -->

    <section class="section-project">
      <div class="section-project-image" style="background-image:url('assets/images/content/bg_project_versalink.jpg');"></div>
      <div class="section-project-content">
        <div class="row">
          <div class="small-6 columns">
            <div class="project-logo"><img src="assets/images/content/logo_versalink.svg" width="393" height="167"></div>
            <div class="project-services">
              <p><strong>Plus 3 Interactive Services:</strong></p>
              <ul>
                <li>Custom Web application</li>
                <li>Application management system (AMS)</li>
                <li>Middleware development</li>
              </ul>
            </div>
            <a href="#project-name-popup" class="btn-white btn-project">View Details</a>
          </div>
        </div>
      </div>
    </section><!-- section-project -->

    <section class="section-project">
      <div class="section-project-image" style="background-image:url('assets/images/content/bg_project_pronto.jpg');"></div>
      <div class="section-project-content">
        <div class="row">
          <div class="small-6 columns">
            <div class="project-logo"><img src="assets/images/content/logo_pronto.png" width="249" height="204"></div>
            <div class="project-services">
              <p><strong>Plus 3 Interactive Services:</strong></p>
              <ul>
                <li>Custom Web application</li>
                <li>Application management system (AMS)</li>
                <li>Middleware development</li>
              </ul>
            </div>
            <a href="#project-name-popup" class="btn-white btn-project">View Details</a>
          </div>
        </div>
      </div>
    </section><!-- section-project -->

    <div id="project-name-popup" class="popup popup-project mfp-hide">
      <div class="popup-pad row">
        <p class="popup-project-logo">
          <img src="assets/images/content/logo_versalink_color.svg" width="310" height="128">
        </p>
        <div class="row">
          <div class="medium-8 columns">
            <h3>Business: Banking Devices</h3>
            <p>VersaLink Communication System is Triton’s proprietary application for monitoring data and health of their smart safes and ATMs, via smart phone or computer.</p>
            <p>We rebuilt VersaLink for efficiency, scalability, performance, and management of multiple devices. We also improved usability while maintaining full compatibility with previous versions. Content TBD</p>
          </div>
          <div class="medium-4 columns">
            <h3>Plus 3 Interactive services:</h3>
            <ul class="blue-list">
              <li><a href="">Custom Web application</a></li>
              <li><a href="">Middleware development</a></li>
              <li><a href="">Device communications</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="popup-footer">
        <p><a href="" class="">For information on how we can help you, please contact us <span class="icon-arrow"></span></a></p>
      </div>
    </div> <!-- popup-project -->
  </div>
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
