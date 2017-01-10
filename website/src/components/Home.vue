<template lang="jade">
div
  HomeBanner
  HomeSolutions
  HomeProcess
  HomeTeam(@open="open")
</template>

<script>
  import HomeBanner from './HomeBanner'
  import HomeSolutions from './HomeSolutions'
  import HomeProcess from './HomeProcess'
  import HomeTeam from './HomeTeam'

  export default {
    name: 'Home',
    components: {
      HomeBanner,
      HomeSolutions,
      HomeProcess,
      HomeTeam
    },
    methods: {
      open (modal) {
        this.$emit('open', modal)
      }
    }
  }
</script>
