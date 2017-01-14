<template lang="jade">
div
  MenuElement(:menu="data.menu")

  p.control
  a.button.is-small(@click="modal.active = true")
    span.icon.is-small
      i.fa.fa-link
    span New Link

  Sortable.repodiv(:list="data.repo", :options="{animation: 150, group: 'items'}")
    div.repo__item(v-for="item in data.repo")
      small.icon.is-small.handle
        i.fa.fa-arrows
      |  {{ item.title }}

  .modal(:class="{'is-active': modal.active}")
    .modal-background
    .modal-card
      header.modal-card-head
        p.modal-card-title Add Link
        button.delete(@click.prevent="modal.active = false")
      section.modal-card-body
        label.label Label
        p.control
          input.input(v-model="link.label")
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
import MenuElement from './Menu'

// @TODO when we get the refreshed menu, we need to re-parse the "repo"

export default {
  components: { Sortable, MenuElement },
  props: [ 'data', 'value', 'pointer' ],
  name: 'menu-editor',
  data () {
    return {
      modal: {
        active: false
      },
      link: {
        url: 'https://www.google.com',
        title: 'Google',
        icon: 'world',
        new_tab: true,
        clickable: true,
        alt: 'google link'
      }
    }
  },
  created () {
    // parse the available items and sync the structure
    this.data.repo.forEach(function (item) {
      item.children = []
    })
  },
  methods: {
    storeLink () {
      this.$http.post(process.env.API_SERVER + 'menus/', this.link)
        .then((response) => {
          let link = response.body
          link.children = []
          this.data.repo.push(link)
          this.modal.active = false
        })
    }
  }
}
</script>

<style lang="sass">
.repo__item
  display: inline-block
  border: 1px solid #ddd
  width: 8rem
  height: 5rem
  margin: 1rem
</style>
