<template>
<!--
            <script src="/assets/js/dist/modernizr-custom.js"></script> -->
            <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
            <div>
              <div class="wrapper">
                  <SiteHeader/>
                  <main class="main">
                      <nuxt/>
                  </main><!-- main -->
                  <SiteFooter/>
              </div><!-- wrapper -->

              <ProposalModal/>
            </div>
</template>

<script>
import SiteHeader from '~components/SiteHeader'
import ProposalModal from '~components/ProposalModal'
import SiteFooter from '~components/SiteFooter'

export default {
  components: {
    SiteHeader,
    SiteFooter,
    ProposalModal
  }
}
</script>
