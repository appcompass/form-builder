<template lang="jade">
div
  div.col-12
    ThickPageBanner
    ContactUs
    MapAddress
</template>

<script>
  import ThickPageBanner from '~components/ThickPageBanner'
  import ContactUs from '~components/ContactUs'
  import MapAddress from '~components/MapAddress'

  export default { components: { ThickPageBanner, ContactUs, MapAddress } }
</script>

