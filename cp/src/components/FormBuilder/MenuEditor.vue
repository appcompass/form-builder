<template lang="jade">
.columns
  .column.is-8
    MenuElement(:menu="data.menu", @deleted="deleted")
    Sortable.empty(v-if="!data.menu.length", :list="data.menu",  :options="{handle: '.handle', animation: 150, group: 'items'}") Empty

    p.control
    a.button.is-small(@click="create('create-link')")
      span.icon.is-small
        i.fa.fa-link
      span New Link

  .column.is-4
    Sortable.menu-list(:list="data.repo", :element="'ul'", :options="{handle: '.handle', animation: 150, group: 'items', clone: true}")
      li(v-for="(item, index) in data.repo")
        a.handle
          &nbsp; {{ item.title }}

</template>

<script>
import Sortable from '../VueSortable'
import MenuElement from './MenuElement'
import Modal from '../Modal'

export default {
  components: { Sortable, MenuElement },
  props: [ 'data', 'value', 'pointer' ],
  name: 'menu-editor',
  data () {
    return {
      modal: Modal,
      link: {url: 'https://www.google.com', title: 'Google', icon: 'world', new_tab: true, clickable: true, alt: 'google link'}
    }
  },
  watch: {
    'data.repo': function (nv, ov) {
      this.setChildren()
    }
  },
  created () {
    this.setChildren()
  },
  methods: {
    deleted (item) {
      // mark items for deletion
      this.data.deletions.push(item.id)
    },
    storeLink (payload) {
      // get a MenuItem instance from the backend
      this.$http.post(process.env.API_SERVER + 'menus/', payload)
        .then((response) => {
          this.data.repo.push(response.body)
          // this.modal.active = false
        })
    },
    setChildren () {
      // make sure every repo item has a children[] element
      let vm = this
      this.data.repo.forEach(function (item, index) {
        if (!item.children) {
          vm.$set(vm.data.repo[index], 'children', [])
        }
      })
    },
    create (item) {
      // fetch desired item and pop up a modal
      // this.modal.active = true
      this.$http.get(process.env.API_SERVER + 'menus/forms/' + item)
        .then(function (response) {
          // response.data.collection -> form.fields
          this.modal.show(response.data.collection, this.link, (result) => {
            return this.storeLink(result)
          })
        })
    }
  }
}
</script>

<style lang="sass">
.repo__item
  display: inline-block
  border: 1px solid #ddd
  width: 12rem
  height: 2rem
  margin: 1rem
</style>
