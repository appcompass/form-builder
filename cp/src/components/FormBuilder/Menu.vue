<template lang="jade">
div.menu.is-11
  Sortable.menu-list(:list="menu", :element="'ul'", :options="options")
    li(v-for="(item, index) in menu")
      a
        small.icon.is-small.handle
          i.fa.fa-arrows

        span.pull-right

          span(v-if="!item.editing", @click="edit(item)")
            small.icon.is-small
              i.fa.fa-edit

          small.icon.is-small.handle(v-if="item.editing", @click="item.editing = false")
            i.fa.fa-save

          small.icon.is-small
            i.fa.fa-trash(@click="remove(item)")

        span(v-if="!item.editing") &nbsp;
          {{ item.label }}

        span(v-if="item.editing")
          input.control(v-model="item.label")

      MenuElement(v-if="item.children.length", :menu="item.children")
      Sortable.menu-list(v-if="!item.children.length", :list="item.children",  :options="options")

</template>

<script>
import Sortable from '../VueSortable'

export default {
  name: 'MenuElement',
  components: { Sortable },
  props: ['menu'],
  data () {
    return {
      options: {
        handle: '.handle',
        animation: 150,
        group: 'items'
      }
    }
  },
  methods: {
    remove (item) {
      // let index = this.menu.indexOf(item)
      // this.$delete(this.menu, index)
    },
    edit (item) {
      this.$set(item, 'editing', true)
    }
  }
}
</script>

<style lang="sass" scoped>
.menu-list li ul
  padding-right: 0
  margin-right: 0
.item
  display: block
  padding: 0.8rem 0 0.8rem 0.8rem
  with: 100%
.empty
  padding: 1rem
  margin: 1rem
  border: 1px dashed rgba(128, 128, 128, 0.2)
  display: inline-block
  width: 100%
  background: rgba(200, 200, 200, 0.2)
</style>
