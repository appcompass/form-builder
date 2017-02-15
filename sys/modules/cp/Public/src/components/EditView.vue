<template lang="jade">
div
  div.columns
    .column.hero.is-danger(v-if="!edit")
      .hero-body
        .container
          h1.title Missing List View Form
          h2.subtitle List Form not provided, please provide one.

    .column(v-else, :class="{'is-8': navigation && navigation.length, 'is-10': !navigation || !navigation.length}")
      h1.title.is-4 Edit: {{ $route.params.model.split('_').pop() }}
        a.button.is-pulled-right(@click="$router.go(-1)")
          span.icon.is-small
            span.fa.fa-angle-left
          .span Back

      .section
        form
          .control(v-for="field in edit.fields")
            label.label {{ field.label }}
            span(
              :is="Components[field.type]",
              :pointer="field.name",
              :data="value(field.name)",
              :source="field.source"
              @input="set"
            )
          footer
            p.control
              .pull-left
                a.button.is-primary(
                  :class="{'is-loading': loading}",
                  :disable="loading",
                  @click="update"
                ) Save

    .column.is-3.is-offset-1(v-if="navigation && navigation.length")
      h1.menu-label Sub Navigation
      aside.menu
        ul.menu-list
          li(v-for="item in navigation")
            router-link(:to="{name: 'sub', params: {model: model.split('/')[model.split('/').length - 2], id: $route.params.id, sub: item.url.split('/')[item.url.split('/').length - 1]}}") {{ item.title }}

  div.columns
    .column.is-12
      router-view

</template>

<script>
import * as Components from './Components'
import State from './State'
import Auth from './Auth'

import swal from 'sweetalert'
import _ from 'lodash'

export default {
  name: 'EditView',
  data () {
    return {
      Components,
      resource: undefined,
      edit: {},
      collection: undefined,
      loading: true,
      model: undefined,
      route: undefined,
      navigation: undefined
    }
  },
  beforeRouteEnter (to, from, next) {
    // @TODO put breadcrumbs here
    return next()
  },
  created () {
    this.model = this.$route.params.model.split('_').join('/') + '/' + this.$route.params.id
    this.refresh()
  },
  watch: {
    '$route' (to, from) {
      this.model = this.$route.params.model.split('_').join('/') + '/' + this.$route.params.id
      this.refresh()
    }

  },
  beforeCreate () {
    // console.log(this.components)
  },
  methods: {
    refresh () {
      var api = process.env.API_SERVER
      this.loading = true
      this.$http.get(api + this.model)
        .then((response) => {
          this.loading = false
          this.collection = response.data.collection
          this.edit = response.data.edit
          this.resource = this.$resource(api + this.edit.resource)

          // we want the last bit of model
          this.route = this.model.split('/')[this.model.split('/').length - 2]

          this.edit.fields.forEach(function (field) {
            field.type = field.type.split('\\')[field.type.split('\\').length - 1]
          })

          State.get(this.route)
            .then(subnav => {
              this.navigation = subnav
            }, (response) => {
              swal({title: 'Error', text: 'Can\'t fetch subnav', type: 'error'})
            })
        }, (response) => {
          if (!Auth.user.authenticated) {
            return
          }
          swal({title: 'Error', text: response.data.errors, type: 'error'})
        })
    },
    set (data) {
      this.$set(this.collection, data.pointer, data.value)
    },
    value (fieldName) {
      return _.get(this.collection, fieldName)
    },
    update () {
      this.loading = true
      this.$http.put(process.env.API_SERVER + this.$route.fullPath.split('_').join('/'), this.collection)
        .then((response) => {
          this.loading = false
          swal({title: 'Success', text: response.data.message, type: 'success'}, () => {
            // fetch a fresh copy of the resource just updated
            this.refresh()
          })
        })
        .catch((response) => {
          this.loading = false
          swal({title: 'Error', text: response.data.errors, type: 'error'})
        })
    }
  }
}
</script>

<style lang="sass" scoped>
  .title
    text-transform: capitalize !important
</style>
