<template lang="jade">
li.draggable(
  draggable="true",
  @dragstart.stop="dragstart",
  @dragend.stop="dragend",
  @unlink.stop="unlink"
)

  div.target(
    @dragover.prevent="hover = true",
    @drop.stop="drop",
    @dragleave="hover = false",
    :class="{hovering: hover}"
  )
    small.icon.is-small.handle
      i.fa.fa-arrows
    |  {{ item.label }}

  draggable(:list="item.children", :options="{group: 'items'}", @start="drag=true", @stop="drag=false")
    Draggable(
      v-for="child, childId in item.children",
      :item="child"
    )
</template>

<script>
// import Sortable from 'sortablejs'
import draggable from 'vuedraggable'

export default {
  name: 'Draggable',
  components: { draggable },
  props: [ 'item' ],
  data () {
    return {
      hover: false
    }
  },
  mounted () {
    /* eslint-disable no-new */
    // new Sortable(document.getElementById('sortable-child'), {
    //   group: 'something',
    //   animation: 150,
    //   handle: '.handle'
    // })
  },
  methods: {
    dragstart (event) {
      // let dragged = JSON.stringify({id: this.item.id, item: this.item})
      // event.dataTransfer.setData('text/plain', dragged)
      // event.target.style.opacity = 0.5
    },
    dragend (event) {
      // event.target.style.opacity = 0.5
      // this.$parent.unlink(this.item.id)
    },
    unlink (id) {
      // this.$delete(this.item.children, id)
    },
    drop (event) {
      // let droppedItem = JSON.parse(event.dataTransfer.getData('text/plain'))
      // this.$set(this.item.children, droppedItem.id, droppedItem.item)
      // this.hover = false
    },
    hovering () {
      // this.hover = true
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
