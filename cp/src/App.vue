<template lang="jade">
div#app
  div.main
    Top
    App
  Bottom.footer
</template>

<script>
import Top from './components/Header'
import App from './components/Main'
import Bottom from './components/Footer'

export default {
  name: 'app',
  components: { Top, App, Bottom }
}
</script>

<style lang="sass" scoped>
#app
  font-family: 'Avenir', Helvetica, Arial, sans-serif
  -webkit-font-smoothing: antialiased
  -moz-osx-font-smoothing: grayscale
  min-height: 100vh
  display: flex
  flex-direction: column

.main
  flex: 1
</style>
