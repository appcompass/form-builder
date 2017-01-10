<template lang="jade">
  header.header
    .logo-wrap
      router-link.logo(v-bind:to="'/'")
        span.visually-hidden Plus 3 Interactive
        a.main-nav-trigger
          span
    Navigation
</template>

<script>
  import Navigation from './Navigation'

  export default {
    name: 'MainHeader',
    components: { Navigation }
  }
</script>
