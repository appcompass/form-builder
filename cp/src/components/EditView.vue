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
            v-bind:data="_.get(collection, field.name)"
            v-bind:value="_.get(collection, field.name)"
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
      ul
        li
          router-link(:to="{name: 'sub', params: {model: 'users', id: $route.params.id, sub: 'groups'}}") Groups
          br
          router-link(:to="{name: 'sub', params: {model: 'users', id: $route.params.id, sub: 'permissions'}}") Permissions
          br
          router-link(:to="{name: 'sub', params: {model: 'websites', id: $route.params.id, sub: 'pages'}}") Pages
          br
          router-link(:to="{name: 'sub', params: {model: 'websites', id: $route.params.id, sub: 'menus'}}") Navigation

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

import swal from 'sweetalert'
import _ from 'lodash'
import SubComponent from './SubComponent'
// import env from 'dotenv'

export default {
  name: 'EditView',
  components: { Formstring, Formtext, Formsecret, Formboolean, Formmenueditor, SubComponent },

  data () {
    return {
      resource: undefined,
      edit: {},
      collection: undefined,
      loading: true
    }
  },

  beforeRouteEnter (to, from, next) {
    // @TODO put breadcrumbs here
    return next()
  },

  created () {
    // @TODO review this
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

    update () {
      this.loading = true
      this.resource.update({id: this.collection.id}, this.collection)
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
