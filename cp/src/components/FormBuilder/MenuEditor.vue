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

  .modal(:class="{'is-active': modal.active}")
    .modal-background
    .modal-card
      header.modal-card-head
        p.modal-card-title Add Link
        button.delete(@click.prevent="modal.active = false")
      section.modal-card-body
        label.label Title
        p.control
          input.input(v-model="link.title")
        label.label Url
        p.control
          input.input(v-model="link.url")
        label.label Alt Text
        p.control
          input.input(v-model="link.alt")
        label.label Icon Name
        p.control
          input.input(v-model="link.icon")
        p.control
          label.checkbox
            input(type="checkbox", v-model="link.new_tab")
            |  New Tab
        p.control
          label.checkbox
            input(type="checkbox", v-model="link.clickable")
            |  Clickable
      footer.modal-card-foot
        a.button.is-primary(@click="storeLink()") Save
        a.button(@click.prevent="modal.active = false") Cancel

</template>

<script>
import Sortable from '../VueSortable'
import MenuElement from './MenuElement'
import Vue from '../../main.js'

export default {
  components: { Sortable, MenuElement },
  props: [ 'data', 'value', 'pointer' ],
  name: 'menu-editor',
  data () {
    return {
      modal: {active: false},
      link: {url: 'https://www.google.com', title: 'Google', icon: 'world', new_tab: true, clickable: true, alt: 'google link'}
    }
  },
  watch: {
    'data.repo': function (nv, ov) {
      this.setChildren()
    }
  },
  created () {
    console.log(Vue.$refs)
    this.setChildren()
  },
  methods: {
    deleted (item) {
      // mark items for deletion
      this.data.deletions.push(item.id)
    },
    storeLink () {
      // get a MenuItem instance from the backend
      this.$http.post(process.env.API_SERVER + 'menus/', this.link)
        .then((response) => {
          this.data.repo.push(response.body)
          this.modal.active = false
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
      this.$http.get(process.env.API_SERVER + 'menus/forms/' + item)
        .then(response => {
          console.log(response)
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
