<template>
  <section v-if="data" class="banner-blue">
    <div class="row">
      <div class="xsmall-12 columns">
        <div class="banner-blue-container">
          <div class="banner-blue-icon"><img src="assets/images/content/icon_maintenance.svg" width="152" height="152"></div>
          <div class="banner-blue-content">
            <h2 class="banner-blue-heading">What about Maintenance?</h2>
            <p>Many companies take a phased approach to roll out. After launch of your Web application, we can customize a maintenance plan that could include:</p>
            <ul>
              <li>Ongoing application design or development</li>
              <li>Ongoing content development</li>
              <li>Research and planning consultations</li>
            </ul>
            <p><b>Please ask us about our maintenance plans.</b></p>
            <a href="" class="btn-white">Contact Us <span class="icon-arrow"></span></a>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
