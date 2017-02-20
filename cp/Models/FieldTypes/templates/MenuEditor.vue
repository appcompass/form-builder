<template lang="jade">
.columns
  .column.is-4
      h1.title Pages
      Sortable.menu-list(:list="data.repo.pages", :element="'ul'", :options="{animation: 300, group: 'items', clone: true}")
        li.repo__item(v-for="(item, index) in data.repo.pages", @dblclick="add(item)")
          p {{ item.title }}

      h1.title(style="margin-top: 3rem") Widgets
      a.button.is-small.pull-right(@click="createLink('create-link')")
        span.icon.is-small
          i.fa.fa-link
        span New Widget
      Sortable.menu-list(:list="data.repo.links", :element="'ul'", :options="{animation: 300, group: 'items', clone: true}")
        li.repo__item(v-for="(item, index) in data.repo.links", @dblclick="add(item)")
          p {{ item.title }}
            small.icon.is-small.pull-right
              i.fa.fa-trash(@click="deleteLink(item)")

  .column.is-8
      h1.title Menu:
      MenuElement(:menu="data.menu", @deleted="deleted")
      Sortable.empty(v-if="!data.menu.length", :list="data.menu",  :options="{handle: '.handle', animation: 300, group: 'items'}")

</template>

<script>
import Sortable from '../VueSortable'
import MenuElement from './MenuElement'
import Modal from '../Modal'
import swal from 'sweetalert'
import _ from 'lodash'

export default {
  components: { Sortable, MenuElement },
  props: [ 'data', 'value', 'pointer' ],
  name: 'menu-editor',
  data () {
    return {
      modal: Modal,
      link: {new_tab: false, clickable: false}
    }
  },
  created () {},
  methods: {
    add (item) {
      this.data.menu.push(_.clone(item, {}, true))
    },
    deleted (item) {
      // mark items for deletion
      if (item.navigatable_id != null) {
        this.data.deletions.push(item.id)
      }
    },
    storeLink (payload) {
      // get a MenuItem instance from the backend
      this.$http.post(process.env.API_SERVER + 'menus/', payload)
        .then((response) => {
          this.data.repo.links.push(response.body.link)
          this.data.menu.push(response.body.menuitem)
        })
    },
    createLink (item) {
      // fetch desired item and pop up a modal
      // this.modal.active = true
      this.$http.get(process.env.API_SERVER + 'menus/forms/' + item)
        .then(function (response) {
          // response.data.collection -> form.fields
          this.modal.show(response.data.collection, this.link, (result) => {
            return this.storeLink(result)
          })
        })
    },
    deleteLink (link) {
      // deletes a Link
      swal({
        title: 'Are you sure?',
        text: 'This will eliminate every instance of this widget from the website',
        type: 'warning',
        showCancelButton: true,
        closeOnConfirm: true
      }, () => {
        this.$http.delete(process.env.API_SERVER + 'menus/links/' + link.id)
          .then(response => {
            this.data.repo.links.splice(this.data.repo.links.indexOf(link), 1)
            swal({title: 'Deleted', type: 'success', timer: 500, showConfirmButton: false})
          }, response => {
            swal({title: 'Error', text: 'Errors while deleting widget', type: 'error'})
          })
      })
    }
  }
}
</script>

<style lang="sass">
.repo__item
  background: #ddd
  display: inline-block
  border: 1px solid #ddd
  width: 100%
  padding: 0.5rem
  margin-bottom: 5px
  &:hover
    background: #ccc
    cursor: pointer
</style>
