<template lang="jade">
div
  Sortable(:list="items", :options="{handle: '.handle', animation: 150, group: 'items'}", @start="drag=true", @stop="drag=false")
    div.item(v-for="item in items")
      small.icon.is-small.handle
        i.fa.fa-arrows
      |  {{ item.label }}
      Sortable(v-if="item.children", :list="item.children", :options="{handle: '.handle', animation: 150, group: 'items'}", @start="drag=true", @stop="drag=false")
        div.item(v-for="child in item.children")
          small.icon.is-small.handle
            i.fa.fa-arrows
          |  {{ child.label }}
</template>

<script>
import Sortable from '../VueSortable'

export default {
  components: { Sortable },
  name: 'menu-editor',
  data () {
    return {
      drag: false,
      items: [
        { id: 1, label: 'Home', children: [ { id: 12, label: 'Something Else', children: [] }, { id: 12, label: 'Again', children: [] } ] },
        { id: 2, label: 'About', children: [] },
        { id: 3, label: 'Contacts', children: [] }
      ]
    }
  }
}
</script>

<style lang="sass">
.placeholder
  display: block
  height: 2rem
  width: 15rem
  background: yellow
.item
  display: block
  padding: 1rem
  margin: 3px 0
  border: 1px dotted #ddd
  border-left: 5px solid #ddd
</style>
