<template lang="jade">
div.menu
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
            i.fa.fa-trash(@click="unlink(item)")

        span(v-if="!item.editing") &nbsp;
          {{ item.title }}

        span(v-if="item.editing")
          input.control(v-model="item.title")

      MenuElement(v-if="item.children.length", :menu="item.children", @deleted="deleted")
      Sortable.empty(v-if="!item.children.length", :list="item.children",  :options="options") Empty
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
  created () {
    let vm = this
    this.$on('deleted', function (item) {
      vm.$emit('delete', item)
    })
  },
  methods: {
    unlink (item) {
      this.menu.splice(this.menu.indexOf(item), 1)
      this.$emit('deleted', item)
    },
    edit (item) {
      this.$set(item, 'editing', true)
    },
    deleted (item) {
      this.$emit('deleted', item)
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
  text-align: center
  color: rgba(128, 128, 128, 0.6)
  margin: 1rem
  padding: 0.5rem 0
  width: 100%
  border: 1px dashed rgba(128, 128, 128, 0.2)
  display: inline-block
  background: rgba(200, 200, 200, 0.2)
</style>
