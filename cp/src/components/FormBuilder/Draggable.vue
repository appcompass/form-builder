<template lang="jade">
li.draggable(draggable="true", @dragstart.stop="dragstart", @dragend.stop="dragend", @unlink.stop="unlink")
  div.target(@drop="drop", @dragover.prevent="hover = true", @dragleave="hover = false", :class="{hovering: hover}") {{ item.label }}
  ul(v-if="item.children")
    Draggable(v-for="child, childId in item.children", :item="child", :id="childId")
</template>

<script>
export default {
  name: 'Draggable',
  props: [ 'id', 'item' ],
  data () {
    return {
      hover: false
    }
  },
  methods: {
    dragstart (event) {
      let dragged = JSON.stringify({id: this.id, item: this.item})
      event.dataTransfer.setData('text/plain', dragged)
      event.target.style.opacity = 0.5
    },
    dragend (event) {
      // let droppedItem = JSON.parse(event.dataTransfer.getData('text/plain'))
      console.log(event)
      // if (this.moved) {
      this.$parent.unlink(this.id)
      // }
      event.target.style.opacity = ''
    },
    unlink (id) {
      this.$delete(this.item.children, id)
    },
    drop (event) {
      let droppedItem = JSON.parse(event.dataTransfer.getData('text/plain'))
      this.$set(this.item.children, droppedItem.id, droppedItem.item)
      droppedItem.moved = true
      this.hover = false
      event.dataTransfer.setData('text/plain', droppedItem)
    },
    hovering () {
      this.hover = true
    }
  }
}
</script>

<style lang="sass" scoped>
.target
  display: block
  padding: 1rem
  border: 1px dotted #ddd
.hovering
  border-style: solid
.draggable
  display: block
  margin: 0.1rem
  border-left: 5px solid #ddd
  padding: 1rem 0 1rem 1rem
</style>
