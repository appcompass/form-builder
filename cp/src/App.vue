<template lang="jade">
div#app
  div.main
    ModalComponent
    Top
    App
  Bottom.footer
</template>

<script>
import Top from './components/Header'
import App from './components/Main'
import Bottom from './components/Footer'
import ModalComponent from './components/ModalComponent'

export default {
  name: 'app',
  components: { Top, App, Bottom, ModalComponent }
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
  background: white

.main
  margin-top: auto
  flex: 1
</style>
