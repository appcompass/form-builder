<template lang="pug">
#app
  //- @TODO: This needs to be dynamic obviously.
  Layouts.Public
</template>

<script>
import * as Layouts from './layouts'

export default {
  name: 'App',
  // components: { Layouts },
  data () {
    return {
      Layouts
    }
  }
}
</script>

<style lang="sass">
@import "./assets/sass/main.scss"
</style>
