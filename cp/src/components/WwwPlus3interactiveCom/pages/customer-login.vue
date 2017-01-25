<template lang="pug">
div
  div
    ThickPageBanner
    CustomerLogin
</template>

<script>
  import ThickPageBanner from '~components/ThickPageBanner'
  import CustomerLogin from '~components/CustomerLogin'

  export default {layout: 'public',components: {ThickPageBanner, CustomerLogin}}
</script>

