<template lang="jade">
div.columns
  .column.is-three-quarters
    h1.title.is-4 New: {{ $route.params.model.slice(0, -1) }}
    form
      .control(v-for="field in create.fields")
        label.label(v-bind:class="{checkbox: field.type === 'boolean'}") {{ field.label }}
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
          a.button.is-primary(@click="save") Save

  .column.is-one-quarter
    p.control
      a.button(@click="$router.go(-1)")
        span.icon.is-small
          span.fa.fa-angle-left
        .span Back
</template>

<script>
import Formstring from './FormBuilder/String'
import Formtext from './FormBuilder/Text'
import Formsecret from './FormBuilder/Secret'
import Formboolean from './FormBuilder/Boolean'
import swal from 'sweetalert'
import _ from 'lodash'

export default {
  name: 'CreateView',
  components: { Formstring, Formtext, Formsecret, Formboolean },
  data () {
    return {
      create: {},
      collection: {}
    }
  },
  created () {
    var api = process.env.API_SERVER

    // this.model = this.$route.params.modelslice(1).split('/').join('_')
    this.model = this.$route.params.model.split('_').join('/')
    console.log(this.model)

    this.$http.get(api + this.$route.path)
      .then((response) => {
        this.create = response.data.edit
        this.resource = this.$resource(api + this.model)
      })
  },
  methods: {
    set (data) {
      _.set(this.collection, data.pointer, data.value)
    },
    value (fieldName) {
      return _.get(this.collection, fieldName)
    },
    save () {
      this.resource.save(this.collection)
        .then((response) => {
          swal({title: 'Success', text: response.data.message, type: 'success'
          }, () => {
            this.$router.push({name: 'edit', params: { model: response.data.model, id: response.data.id }})
          })
        })
        .catch((response) => {
          swal('Error', response.data.errors, 'error')
        })
    }
  }
}
</script>

<style lang="sass" scoped>
  .title
    text-transform: capitalize !important
</style>
