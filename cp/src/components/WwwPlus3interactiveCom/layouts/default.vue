<template>
    <html class="no-js" lang="">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <title>Title</title>
            <meta name="description" content="">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="icon" type="image/png" href="favicon.png">

            <link type="text/css" rel="stylesheet" href="http://fast.fonts.net/cssapi/e1ef451d-c61f-4ad3-b4e0-e3d8adb46d89.css"/>
            <link rel="stylesheet" href="/assets/css/main-min.css">

            <script src="/assets/js/dist/modernizr-custom.js"></script>
        </head>
        <body class="">
            <!--[if lt IE 8]>
                <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
            <![endif]-->
            <div class="wrapper">
                <SiteHeader/>
                <main class="main">
                    <nuxt/>
                </main><!-- main -->
                <SiteFooter/>
            </div><!-- wrapper -->

            <ProposalModal/>

            <!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if offline -->
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
            <script src="/assets/js/dist/main-min.js"></script>

        </body>
    </html>
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
