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
import Sortable from '../VueSortable'

export default {
  name: 'Draggable',
  components: { draggable },
  props: [ 'item' ]
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
