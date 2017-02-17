<template lang="jade">
  div.columns
    .column(v-if="!list && !loading")
      .hero.is-bold.is-danger
        .container
          .hero-body
            .container
              h1.title Missing List View Form
              h2.subtitle  List Form are build using the
                strong  ResourceBuilder,
                |  please provide one.

    .column.is-11(v-if="list")
      p.control.pull-right
        router-link.button.is-small.is-primary(:to="{name: 'create', params: {model: model}}")
          span.icon.is-small
            i.fa.fa-plus
          span Create

      h1.title.is-4 List: {{ $route.params.sub || $route.params.model }}

      Pagination(:p="pagination", :disabled="loading", v-if="pagination.last_page > 1")

      main.main

        div.overlay.is-full-width(v-if="loading")
            section.content.has-text-centered
              p.notification.is-info.title.is-5 crafting the resource you requested...

        section(
          v-if="list"
          v-bind:is="list.list_layout + 'List'"
          v-bind:sorters="sorters"
          v-bind:loading="loading"
          v-bind:collection="collection"
          v-bind:model="model"
          v-bind:search="search"
          v-bind:forms="{list: list, edit: edit}"
        )

      Pagination(:p="pagination", :disabled="loading", v-if="pagination.last_page > 1")
</template>

<script>
import swal from 'sweetalert'
import _ from 'lodash'
import Pagination from './Pagination'
import TableList from './LayoutTypes/TableList'
import MultiSelectList from './LayoutTypes/MultiSelectList'
import PageEditorList from './LayoutTypes/PageEditorList'
import Auth from './Auth.js'

export default {
  name: 'ListView',

  components: { Pagination, TableList, MultiSelectList, PageEditorList },

  data () {
    return {
      edit: [],
      list: undefined,
      model: '',
      collection: {},
      search: {},
      sorters: {},
      loading: true,
      pagination: {surrounded: 3},
      watcherFired: false
    }
  },

  watch: {
    'pagination.current_page' (nv, ov) {
      this.update()
    },
    '$route' (to, from) {
      this.search = {}
      if (to.path === from.path) {
        return
      }
      this.model = to.path
      this.loading = true

      this.sorters = {}
      this.search = {}

      // we trigger an update only if page stays the same, otherwise we let pagination watcher fire the query
      if (this.pagination.current_page === 1) {
        this.update()
      } else {
        this.pagination.current_page = 1
      }
    }
  },
  created () {
    this.update()
  },
  methods: {
    applyFilter: _.debounce(function () {
      if (this.pagination.current_page > 1) {
        this.pagination.current_page = 1
      } else {
        this.update()
      }
    }, 500),
    update () {
      var api = process.env.API_SERVER
      this.loading = true
      this.model = this.$route.path
      this.$http.get(api + this.$route.path.slice(1), {
        params: {
          page: this.pagination.current_page,
          search: this.search,
          sorters: this.sorters
        }
      })
        .then((response) => {
          this.loading = false
          if (!response.data.list) {
            this.list = undefined
            return
          }
          this.list = response.data.list
          // check if collection sets it's own view layout [Card, Table, MultiSelect]
          if (response.data.collection.view != null) {
            this.list.list_layout = response.data.collection.view
          }
          this.pagination = _.omit(response.data.collection.data, ['data'])
          this.collection = response.data.collection
          this.resource = this.$resource(api + this.list.resource)
          this.resource = this.$resource(api + this.$route.path.slice(1))
        }, (response) => {
          this.loading = false
          if (!Auth.user.authenticated) {
            return
          }
          swal('Error!', response.data.errors, 'error')
        })
    },
    remove (id) {
      swal({ title: 'Are you sure?', text: 'You will not be able to recover this', type: 'warning', showCancelButton: true, closeOnConfirm: false }, () => {
        var api = process.env.API_SERVER
        this.$http.delete(api + this.$route.path.slice(1) + '/' + id)
        // this.resource.delete(id)
          .then((response) => {
            swal({title: 'Success', text: response.data.message, type: 'success'}, () => {
              return this.update()
            })
          })
          .catch((response) => {
            swal('Error!', response.data.message, 'error')
          })
      })
    },
    toggleEdit (field) {
      if (this.edit.indexOf(field.id) > -1) {
        delete this.search[field.name]
        this.edit.splice(this.edit.indexOf(field.id), 1)
        if (this.pagination.current_page > 1) {
          this.pagination.current_page = 1
        } else {
          this.update()
        }
      } else {
        this.edit.push(field.id)
      }
    },
    toggleSorter (field) {
      if (!field.config.sortable) {
        return
      }
      let sorter = this.sorters[field.name]
      switch (sorter) {
        case 'ASC':
          this.$set(this.sorters, field.name, 'DESC')
          break
        case 'DESC':
          this.$delete(this.sorters, field.name)
          break
        default:
          this.$set(this.sorters, field.name, 'ASC')
      }
      this.update()
    }
  }
}
</script>

<style lang="sass">
.is-opaque
  opacity: 0.4

input[disabled]
  background: transparent
  border: 0
  font-weight: bold
  &::before
    content: '&gt'
    position: abosolute
    top: 0
    right: 0
    z-index: 10000
.main
  position: relative

.filter-toggle
  opacity: 0.2
  &:hover
    color: blue
    cursor: pointer

.is-sortable
  position: relative
  border-bottom: 1px solid #ddd

  &.is-active
    border: 0
    &::after
      color: blue

  &.asc
    &::after
      content: " #{'\f077'}"
      font-family: 'FontAwesome'
      margin-left: 1rem
  &.desc
    &::after
      content: " #{'\f078'}"
      font-size: 0.8rem
      font-family: 'FontAwesome'
      margin-left: 1rem

.overlay
  position: absolute
  width: 100%
  z-index: 1000
  opacity: 0.8
</style>
