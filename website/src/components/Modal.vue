<template lang="jade">
.popup.popup-proposal(v-show="modal.active")
  div(v-bind:is="modal.type")
</template>

<script>
  import $ from 'jquery'
  import Proposal from './Proposal'
  import Imene from './Imene'

  export default {
    name: 'Modal',
    props: [ 'modal' ],
    components: { Proposal, Imene },
    methods: {
      show (type) {
        if (type) {
          this.modal.type = type
        }
        var vm = this
        $.magnificPopup.open({
          items: {
            src: $(this.$el),
            type: 'inline'
          },
          callbacks: {
            open () {},
            close () {
              vm.$emit('close')
            }
          }
        })
      },
      hide () {
        this.modal.active = false
        $.magnificPopup.close($(this.$el))
      }
    },
    mounted () {
      if (this.$route.hash.indexOf('#') > -1) {
        this.show(this.$route.hash.slice(1))
        this.modal.active = true
      }
    },
    watch: {
      modal (nv) {
        if (nv.active) {
          this.show()
        }
      },
      '$route' (to, from) {
        if (to.hash.indexOf('#') === -1 && this.modal.active) {
          this.hide()
        }

        if (to.hash.indexOf('#') > -1 && !this.modal.active) {
          this.modal.active = true
          this.show(to.hash.slice(1))
        }
      }
    }
  }
</script>

<style lang="sass">
  .modal-enter-active
    opacity: 1
    transition: all 1.2s
</style>
