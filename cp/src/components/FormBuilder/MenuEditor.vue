<template lang="jade">
div
  Sortable(:list="data.menu", :options="{handle: '.handle', animation: 150, group: 'items'}")
    div.item(v-for="(item, index) in data.menu")
      small.icon.is-small.handle
        i.fa.fa-arrows
      input(v-model="item.label")
      small.icon.is-small
        i.fa.fa-trash(@click="remove(index)")

      Sortable(v-if="item.children && item.children.length", :list="item.children", :options="{handle: '.handle', animation: 150, group: 'items'}")
        div.item(v-for="(child, index) in item.children")
          small.icon.is-small.handle
            i.fa.fa-arrows
          input(v-model="child.label")
          small.icon.is-small
            i.fa.fa-trash(@click="remove(index)")

      Sortable.empty(v-else, :list="item.children",  :options="{handle: '.handle', animation: 150, group: 'items'}")

  Sortable.repodiv(:list="data.repo", :options="{animation: 150, group: 'items'}")
    div.repo__item(v-for="item in data.repo")
      small.icon.is-small.handle
        i.fa.fa-arrows
      |  {{ item.name || item.label }}

</template>

<script>
import Sortable from '../VueSortable'

// @TODO when we get the refreshed menu, we need to re-parse the "repo"

export default {
  components: { Sortable },
  props: [ 'data', 'value', 'pointer' ],
  name: 'menu-editor',
  created () {
    this.data.repo.forEach(function (item) {
      item.label = item.name.charAt(0).toUpperCase() + item.name.slice(1)
      item.children = []
    })
    this.deleted = []
  },
  methods: {
    remove (index) {
      this.data.menu.splice(index, 1)
    }
  }
}
</script>

<style lang="sass">
.repodiv, .empty
  margin-top: 3rem
  height: 3rem
.repo__item
  display: inline-block
  border: 1px solid #ddd
  width: 8rem
  height: 5rem
  margin: 1rem
.placeholder
  display: block
  height: 2rem
  width: 15rem
  background: yellow
.item
  display: block
  padding: 0.8rem
  margin: 3px 0
  border: 1px dotted #ddd
</style>
