<template lang="jade">
div.menu
  Sortable.menu-list(:list="menu", :element="'ul'", :options="options")
    li(v-for="(item, index) in menu")
      a
        small.icon.is-small.handle
          i.fa.fa-arrows

        span.pull-right
          span.icon.is-small(@click="collapse(item, true)", v-if="item.children.length && !item.isCollapsed", style="margin-right: 5px")
            i.fa.fa-minus-square-o
          span.icon.is-small(@click="collapse(item, false)", v-if="item.isCollapsed", style="margin-right: 5px")
            i.fa.fa-plus-square
          span(@click="edit(item)", style="margin-right: 5px")
            small.icon.is-small
              i.fa.fa-edit
          small.icon.is-small
            i.fa.fa-trash(@click="unlink(item)")

        span  {{ item.title }}

      MenuElement(v-if="item.children.length && !item.isCollapsed", :menu="item.children", @deleted="deleted")
      Sortable.empty(v-if="!item.children.length", :list="item.children",  :options="options") Empty
</template>

<script>
import Sortable from '../VueSortable'
import Modal from '../Modal'
import swal from 'sweetalert'

export default {
  name: 'MenuElement',
  components: { Sortable },
  props: ['menu'],
  data () {
    return {
      endpoint: null,
      modal: Modal,
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
    collapse (item, collapsed) {
      this.$set(item, 'isCollapsed', collapsed)
    },
    edit (item) {
      if (item.type !== null) {
        switch (item.type) {
          case 'Link':
            this.endpoint = 'edit-link'
            break
          case 'Page':
            this.endpoint = 'edit-menu-item'
            break
        }
      }
      this.$http.get(process.env.API_SERVER + 'menus/forms/' + this.endpoint)
        .then((response) => {
          this.modal.show(response.data.collection, item, (result) => {
            this.$http.post(process.env.API_SERVER + 'menus/forms/' + this.endpoint, result)
              .then((response) => {
                swal({title: 'Updated', type: 'success'})
              })
          })
        })
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
.icon:hover
  color: red
li a:hover
  background: white
  color: #333
</style>
