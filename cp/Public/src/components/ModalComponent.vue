<template lang="jade">
  .modal(:class="{'is-active': modal.active}")
    .modal-background
    .modal-content
      .modal-card
        header.modal-card-head
          p.modal-card-title Title Here
          button.delete(@click.prevent="modal.disable()")
        section.modal-card-body
          span(v-if="modal.form", v-for="field in modal.form")
            label.label {{ field.label }}
            span(
              v-bind:is="Components[field.type]",
              v-bind:pointer="field.name"
              v-bind:data="modal.value(field.name)"
              v-bind:value="modal.value(field.name)"
              @input="setModalData"
            )

        footer.modal-card-foot
          a.button.is-primary(@click="modalDone") Save
          a.button(@click.prevent="modal.disable()") Cancel
</template>

<script>
import Modal from './Modal'
import * as Components from './Components'

export default {
  name: 'ModalComponent',
  data () {
    return {
      data: {},
      Components,
      modal: Modal
    }
  },
  methods: {
    setModalData (data) {
      this.modal.set(data)
    },
    modalDone () {
      this.modal.done()
    }
  }
}
</script>
