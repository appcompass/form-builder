<template lang="jade">
div
  ul
    Draggable(v-for="item, id in items", :item="item", :id="id", @unlink="unlink")
    //- root dropzone
    li
      div.target(@drop="drop", @dragover.prevent="") Root Dropzone
</template>

<script>
import Draggable from './Draggable'

export default {
  components: { Draggable },
  name: 'menu-editor',
  data () {
    return {
      items: {
        1: { label: 'Home', children: { 12: { label: 'Something Else', children: {} } } },
        2: { label: 'About', children: {} },
        3: { label: 'Contacts', children: {} }
      }
    }
  },
  methods: {
    drop (event) {
      let droppedItem = JSON.parse(event.dataTransfer.getData('text/plain'))
      this.$set(this.items, droppedItem.id, droppedItem.item)
    },
    unlink (id) {
      console.log('Got Unlink in root!')
      this.$delete(this.items, id)
    }
  }
}
</script>

<style lang="sass">
.target
  display: block
  padding: 1rem
  border: 1px dotted #ddd
</style>
