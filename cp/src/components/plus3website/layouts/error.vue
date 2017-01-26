<template>
    <!--[if lt IE 8]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div>
        <div class="wrapper">
            <SiteHeader/>
            <main class="main">
                <h1 class="title">
                  {{ error.statusCode }}
                </h1>
                <h2 class="info">
                  {{ error.message }}
                </h2>
                <nuxt-link class="button" to="/" v-if="error.statusCode === 404">
                  Homepage
                </nuxt-link>
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
  props: ['error'],
  components: {
    SiteHeader,
    SiteFooter,
    ProposalModal
  }
}
</script>
