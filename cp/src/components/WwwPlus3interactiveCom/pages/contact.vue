<template lang="pug">
div
  div
    ThickPageBanner
    ContactUs
    MapAddress
</template>

<script>
  import ThickPageBanner from '~components/ThickPageBanner'
  import ContactUs from '~components/ContactUs'
  import MapAddress from '~components/MapAddress'

  export default {layout: 'public',components: {ThickPageBanner, ContactUs, MapAddress}}
</script>

