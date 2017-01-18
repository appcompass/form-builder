<template lang="jade">
div
  MenuElement(:menu="data.menu", @deleted="deleted")
  Sortable.empty(v-if="!data.menu.length", :list="data.menu",  :options="{handle: '.handle', animation: 150, group: 'items'}") Empty

  p.control
  a.button.is-small(@click="modal.active = true")
    span.icon.is-small
      i.fa.fa-link
    span New Link

  .section
    h1.title Current Pages
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
  created () {},
  methods: {
    deleted (item) {
      this.data.deletions.push(item.id)
    },
    storeLink () {
      this.$http.post(process.env.API_SERVER + 'menus/', this.link)
        .then((response) => {
          this.data.repo.push(response.body)
          this.modal.active = false
        })
    },
    setChildren () {
      let vm = this
      this.data.repo.forEach(function (item, index) {
        vm.$set(vm.data.repo[index], 'children', [])
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
