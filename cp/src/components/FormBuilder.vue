<template lang="jade">
div
  span(v-if="form", v-for="field in form")
    label.label {{ field.label }}
    a.icon.is-small(v-if="field.repeatable", @click="clone(field.name)")
      i.fa.fa-clone
    span(
        :is="Components[field.type]",
        :pointer="field.name",
        :data="value(field.name)",
        :value="value(field.name)"
        @input="set"
      )
    div(v-if="field.fields.length", v-for="(val, $index) in value(field.name)")
      a.icon.is-small.pull-right(@click="unlink(field.name, $index)", v-if="field.repeatable")
        i.fa.fa-trash-o
      FormBuilder.fieldset(
        :form="field.fields",
        :content="val",
      )
</template>

<script>
import * as Components from './Components'
import _ from 'lodash'

export default {
  name: 'FormBuilder',
  props: [ 'form', 'content' ],
  data () {
    return {
      dataObject: null,
      Components
    }
  },
  mounted () {
  },
  methods: {
    clone (fieldName) {
      this.content[fieldName].push({})
    },
    set (data) {
      _.set(this.content, data.pointer, data.value)
    },
    value (fieldName, $index) {
      // fetches a value in an array or as single
      let c = _.get(this.content, fieldName)
      if ($index >= 0) {
        return c[$index]
      } else {
        return c
      }
    },
    unlink (fieldName, $index) {
      this.content[fieldName].splice($index, 1)
    }
  }
}
</script>

<style lang="sass">
.fieldset
  border: 1px solid #ddd
  box-shadow: 5px 5px 10px #ddd
  padding: 1rem
</style>
