<template lang="jade">
div
  span(v-if="form", v-for="(field, fieldIndex) in form")
    label.label(v-if="!field.repeatable") {{ field.label }}
    a.icon.is-small(v-if="field.repeatable", @click="clone(field.name, fieldIndex)")
      i.fa.fa-clone

    div(v-if="Array.isArray(value(field.name)) && !field.fields.length", v-for="(single, subFieldIndex) in value(field.name)")
      span.pull-right.icon.is-small(@click="unlink(field.name, subFieldIndex)")
        i.fa.fa-trash-o
      span(
          :is="Components[field.type]",
          :pointer="field.name",
          :data="single",
          :value="single",
          @input="set(single, subFieldIndex)"
        )

    span(
        v-if="!Array.isArray(value(field.name))",
        :is="Components[field.type]",
        :pointer="field.name",
        :data="value(field.name)",
        :value="value(field.name)",
        @input="set"
      )

    Sortable(v-if="field.repeatable && field.fields.length", :list="value(field.name)", :options="{handle: '.handle', animation: 150, group: 'items'}")
      div(v-for="(val, index) in value(field.name)")

        span.icon.is-small(@click="collapse(value(field.name, index), true)", v-if="!value(field.name, index).isCollapsed")
          i.fa.fa-minus-square-o

        span.icon.is-small(@click="collapse(value(field.name, index), false)", v-if="value(field.name, index).isCollapsed")
          i.fa.fa-plus-square
        span  {{ value(field.name, index).title }}

        a.icon.is-small.pull-right(@click="unlink(field.name, index)")
          i.fa.fa-trash-o

        a.icon.is-small.pull-right.handle(v-if="value(field.name, index).isCollapsed")
          i.fa.fa-arrows

        FormBuilder.fieldset(
          v-if="!val.isCollapsed",
          :form="field.fields",
          :content="val",
        )
</template>

<script>
import * as Components from './Components'
import _ from 'lodash'
import Sortable from './VueSortable'

export default {
  name: 'FormBuilder',
  props: [ 'form', 'content' ],
  components: { Sortable },
  data () {
    return {
      Components
    }
  },
  methods: {
    clone (fieldName, fieldIndex) {
      // when cloning check if we're cloning a fieldset or a single repeatable (with multiple values)
      if (this.form[fieldIndex].fields.length) {
        let dataObject = Object.create({})
        this.form[fieldIndex].fields.forEach((item) => {
          dataObject[item.name] = null
        })
        this.content[fieldName].push(dataObject)
      } else {
        if (!Array.isArray(this.content[fieldName])) {
          this.$set(this.content, fieldName, [])
        }
        this.content[fieldName].push('')
      }
    },
    set (data, index) {
      if (Array.isArray(this.content[data.pointer])) {
        if (index) {
          this.content[data.pointer][index] = data.value
        }
      } else {
        _.set(this.content, data.pointer, data.value)
      }
    },
    value (fieldName, $index) {
      // _.get the element in content object
      let c = _.get(this.content, fieldName)

      // if it returns an array we look at $index, if preset
      if ($index >= 0 && Array.isArray(c)) {
        // return that specific value
        return c[$index]
      } else {
        // else return whatever you found (single value, whole array)
        return c
      }
    },
    collapse (item, collapsed) {
      this.$set(item, 'isCollapsed', collapsed)
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
