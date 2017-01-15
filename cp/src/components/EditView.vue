<template lang="jade">
div
  div.columns
    .column.hero.is-danger(v-if="!edit")
      .hero-body
        .container
          h1.title Missing List View Form
          h2.subtitle List Form not provided, please provide one.

    .column.is-8(v-else)
      h1.title.is-4 Edit: {{ $route.params.model.split('_').pop() }}
        a.button.is-pulled-right(@click="$router.go(-1)")
          span.icon.is-small
            span.fa.fa-angle-left
          .span Back

      form
        .control(v-for="field in edit.fields")
          label.label {{ field.label }}
          span(
            v-bind:is="'Form' + field.type",
            v-bind:pointer="field.name"
            v-bind:data="value(field.name)"
            v-bind:value="value(field.name)"
            @input="set"
          )
      footer
        p.control
          .pull-right
            a.button.is-primary(
              v-bind:class="{'is-loading': loading}",
              v-bind:disable="loading",
              @click="update"
            ) Save

    div
      h1 Sub Navigation
      aside.menu
        ul.menu-list
          li(v-for="item in navigation")
            router-link(:to="{name: 'sub', params: {model: item.url.split('/')[1], id: $route.params.id, sub: item.url.split('/')[item.url.split('/').length - 1]}}") {{ item.title }}

  div.columns
    .column.is-12
      router-view

</template>

<script>
import Formstring from './FormBuilder/String'
import Formtext from './FormBuilder/Text'
import Formsecret from './FormBuilder/Secret'
import Formboolean from './FormBuilder/Boolean'
import Formmenueditor from './FormBuilder/MenuEditor'
import State from './State'

import swal from 'sweetalert'
import _ from 'lodash'

function findObject (title, haystack, res) {
  for (let i = 0; i < haystack.length; i++) {
    let current = haystack[i]
    if (current.title === title) {
      res = current.children
    } else if (current.children.length) {
      res = findObject(title, current.children, res)
    }
  }

  return res
}

export default {
  name: 'EditView',
  components: { State, Formstring, Formtext, Formsecret, Formboolean, Formmenueditor },

  data () {
    return {
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
    // @TODO review this
    State.getNavigation()
      .then(navigation => {
        this.navigation = navigation
        let route
        // here we look at path length after splitting (i think) depending on that we take either the 1st, 3rd, 5th param /websites/1/pages/1/
        this.$route.path.slice(1).split('_').join('/').split('/').forEach((element, index) => {
          if (index % 2 === 0) {
            route = element
          }
        })
        this.route = route
        console.log(route)
        route = route.charAt(0).toUpperCase() + route.slice(1)
        this.navigation = findObject(route, navigation)
      })
    this.model = this.$route.params.model.split('_').join('/') + '/' + this.$route.params.id
    this.refresh()
  },

  watch: {
    '$route' (to, from) {
      this.model = this.$route.params.model.split('_').join('/') + '/' + this.$route.params.id
      this.refresh()
    }

  },

  methods: {
    // we refresh in a decent number of instances, but have to make sure after PUTting we propagate the refreshed stuff down to the actual items
    refresh () {
      var api = process.env.API_SERVER
      this.loading = true
      this.$http.get(api + this.model)
        .then((response) => {
          this.loading = false
          this.collection = response.data.collection
          this.edit = response.data.edit
          this.resource = this.$resource(api + this.edit.resource)
        })
        .catch((response) => {
          this.loading = false
          swal({title: 'Error', text: response.data.errors, type: 'error'})
        })
    },
    set (data) {
      _.setWith(this.collection, data.pointer, data.value)
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
