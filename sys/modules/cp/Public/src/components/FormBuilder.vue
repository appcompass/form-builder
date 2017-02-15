<template lang="jade">
div
  span(v-if="form", v-for="(field, fieldIndex) in form")
    label.label(v-if="!field.repeatable") {{ field.label }}
    a.icon.is-small(v-if="field.repeatable", @click="clone(field.name, fieldIndex)")
      i.fa.fa-plus

    //- SINGLE VALUE (single value returned from content for field)
    span(
        v-if="!Array.isArray(value(field))",
        :is="Components[field.type]",
        :pointer="field.name",
        :data="value(field)",
        :value="value(field)",
        @input="set"
      )

    //- SINGLE FIELD REPEATABLE (multiple values but no sub-form) -- value(field) returns an array
    div(v-if="Array.isArray(value(field)) && !field.fields.length", v-for="(single, subFieldIndex) in value(field)")
      span.pull-right.icon.is-small(@click="unlink(field, subFieldIndex)")
        i.fa.fa-trash-o
      span(
        :is="Components[field.type]",
        :pointer="field.name",
        :data="single",
        :value="single",
        @input="function(e) { return set(e, subFieldIndex); }"
      )

    //- MULTI FIELD REPEATABLE SORTABLE (sub-form present, has multiple values and field.repeatable is true)
    Sortable(v-if="field.repeatable && field.fields.length", :list="value(field)", :options="{handle: '.handle', animation: 150, group: 'items'}")
      div(v-for="(val, index) in value(field)")

        span.icon.is-small(@click="collapse(value(field, index), true)", v-if="!value(field, index).isCollapsed")
          i.fa.fa-minus-square-o

        span.icon.is-small(@click="collapse(value(field, index), false)", v-if="value(field, index).isCollapsed")
          i.fa.fa-plus-square
        span  {{ value(field, index).title || '' }}

        a.icon.is-small.pull-right(@click="unlink(field, index)")
          i.fa.fa-trash-o

        a.icon.is-small.pull-right.handle(v-if="value(field, index).isCollapsed")
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
      Components,
      subFieldIndex: null
    }
  },
  methods: {
    // adds a repeatable
    clone (fieldName, fieldIndex) {
      // when cloning check if we're cloning a fieldset or a single repeatable (with multiple values)

      // Fieldset (we have a fields subset)- get the fields
      if (this.form[fieldIndex].fields.length) {
        let dataObject = Object.create({})
        this.form[fieldIndex].fields.forEach((item) => {
          dataObject[item.name] = null
        })
        // make sure the content field is able to receive dataplus
        if (!this.content[fieldName]) {
          this.$set(this.content, fieldName, [])
        }
        this.content[fieldName].push(dataObject)

      // Single Field - keep old data and make it an array
      // @TODO, what if backend expects an array -> cast to make sure
      } else {
        if (!Array.isArray(this.content[fieldName])) {
          this.$set(this.content, fieldName, [this.content[fieldName]])
        }
        this.content[fieldName].push('')
      }
    },
    // _.get the element in content object
    value (field, index) {
      let c = _.get(this.content, field.name)

      // in case field has a source we want that as data source
      if (field.source) {
        return {
          data: c,
          source: field.source
        }
      }
      // if it returns an array we look at index, if preset
      if (index >= 0 && Array.isArray(c)) {
        // return that specific value
        return c[index]
      } else {
        // else return whatever you found (single value, whole array)
        return c
      }
    },
    // sets a value
    set (data, index) {
      // based on index
      if (Array.isArray(this.content[data.pointer])) {
        if (index) {
          this.$set(this.content[data.pointer], index, data.value)
        }
      // or on an object
      } else {
        _.set(this.content, data.pointer, data.value)
      }
    },
    // collapse a structure
    collapse (item, collapsed) {
      this.$set(item, 'isCollapsed', collapsed)
    },
    // remove branch
    unlink (field, index) {
      this.content[field.name].splice(index, 1)
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
