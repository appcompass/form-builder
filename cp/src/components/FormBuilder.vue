<template lang="jade">
div
  span(v-if="form", v-for="field in form")
    label.label {{ field.label }}
    span.icon.is-small(v-if="field.repeatable", @click="clone(field)")
      i.fa.fa-clone
    span(
        :is="Components[field.type]",
        :pointer="field.name",
        :data="value(field.name)",
        :value="value(field.name)"
      )
    FormBuilder(v-if="field.fields", :form="field.fields")
</template>

<script>
import * as Components from './Components'
import _ from 'lodash'

export default {
  name: 'FormBuilder',
  props: [ 'form' ],
  data () {
    return {
      dataObject: null,
      Components
    }
  },
  methods: {
    clone (field) {
      this.$emit('add', field)
    },
    set (data) {
      _.set(this.dataObject, data.pointer, data.value)
    },
    value (fieldName) {
      return _.get(this.dataObject, fieldName)
    }
  }
}
</script>
