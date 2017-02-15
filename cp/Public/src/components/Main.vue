<template lang="jade">
main.section
  .columns
    .column.is-2
      Navigation
    .column
      transition(name="route", mode="out-in")
        router-view
</template>

<script>
import Navigation from './Navigation'

export default {
  name: 'Main',
  components: { Navigation }
}
</script>

<style lang="sass" scoped>
.route-enter-active
  transition: all .2s
  opacity: 1

.route-leave-active
  transition: all .2s
  opacity: 0

.navigation
  background: red
</style>
