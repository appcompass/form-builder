<template lang="jade">
div
  transition(name="fade", mode="out-in")
    Modal(v-bind:modal="modal", @close="close")

  div
    Top
    main.main
      transition(name="fade", mode="out-in")
        router-view(@open="open")
    Bottom(@open="open")
</template>

<script>
  import Top from './components/Top'
  import Modal from './components/Modal'
  import Bottom from './components/Bottom'

  export default {
    name: 'App',
    data () {
      return {
        modal: {
          active: false,
          type: undefined
        }
      }
    },
    methods: {
      open (modal) {
        this.modal = modal
        this.$router.push({ hash: modal.type })
      },
      close () {
        this.modal.active = false
        this.$router.push({ hash: '' })
      }
    },
    components: {
      Top,
      Modal,
      Bottom
    }
  }
</script>

<style lang="sass">
.fade-enter-active
  animation: fadeIn .65s

.fade-leave-active
  opacity: 0
</style>
