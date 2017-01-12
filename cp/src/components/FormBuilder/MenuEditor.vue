<template lang="jade">
div
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

  div.columns
    div.column.is-12
      Sortable(:list="data.menu", :options="{handle: '.handle', animation: 150, group: 'items'}")
        div.item(v-for="(item, index) in data.menu")
          small.icon.is-small.handle
            i.fa.fa-arrows
          input(v-model="item.label")
          small.icon.is-small
            i.fa.fa-trash(@click="remove(index, item)")

          Sortable(v-if="item.children && item.children.length", :list="item.children", :options="{handle: '.handle', animation: 150, group: 'items'}")
            div.item(v-for="(child, childIndex) in item.children")
              small.icon.is-small.handle
                i.fa.fa-arrows
              input(v-model="child.label")
              small.icon.is-small
                i.fa.fa-trash(@click="remove(childIndex, child, item)")

          Sortable.empty(v-else, :list="item.children",  :options="{handle: '.handle', animation: 150, group: 'items'}")

        p.control
          a.button.is-small(@click="modal.active = true")
            span.icon.is-small
              i.fa.fa-link
            span New Link

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
  data () {
    return {
      modal: {
        active: false
      },
      link: {
        url: 'https://www.google.com',
        label: 'Google',
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
      if (!item.label && item.name) {
        item.label = item.name.charAt(0).toUpperCase() + item.name.slice(1)
      } else if (!item.name) {
        item.name = item.label
      }
      item.children = []
    })
  },
  methods: {
    // index -> rendering index
    // parent -> nullable parent (root or children?)
    //
    remove (index, item, parent = null) {
      if (parent) {
        parent.children.splice(index, 1)
      } else {
        this.data.menu.splice(index, 1)
      }
      this.data.deletions.push(item.id)
    },
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
