<template lang="jade">
.columns
  .column.is-8
    MenuElement(:menu="data.menu", @deleted="deleted")
    Sortable.empty(v-if="!data.menu.length", :list="data.menu",  :options="{handle: '.handle', animation: 150, group: 'items'}") Empty

    p.control
    a.button.is-small.is-success(@click="createLink('create-link')")
      span.icon.is-small
        i.fa.fa-link
      span New Link

  .column.is-4
    .section
      h1.title Pages
      Sortable.menu-list(:list="data.repo.pages", :element="'ul'", :options="{handle: '.handle', animation: 150, group: 'items', clone: true}")
        li(v-for="(item, index) in data.repo.pages")
          a
            small.icon.is-small.handle
              i.fa.fa-arrows
            |  {{ item.title }}
    .section
      h1.title Links
      Sortable.menu-list(:list="data.repo.links", :element="'ul'", :options="{handle: '.handle', animation: 150, group: 'items', clone: true}")
        li(v-for="(item, index) in data.repo.links")
          a
            small.icon.is-small.handle
              i.fa.fa-arrows
            |  {{ item.title }}
            small.icon.is-small.pull-right
              i.fa.fa-trash(@click="deleteLink(item)")


</template>

<script>
import Sortable from '../VueSortable'
import MenuElement from './MenuElement'
import Modal from '../Modal'
import swal from 'sweetalert'

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
    deleted (item) {
      // mark items for deletion
      this.data.deletions.push(item.id)
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
        text: 'This will eliminate every instance of this link from the website',
        type: 'warning',
        showCancelButton: true,
        closeOnConfirm: false
      }, () => {
        this.$http.delete(process.env.API_SERVER + 'menus/' + link.id)
          .then(response => {
            this.data.repo.links.splice(this.data.repo.links.indexOf(link), 1)
          }, response => {
            console.log(response)
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

