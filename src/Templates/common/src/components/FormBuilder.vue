<template>
<div>
  <span class="row" v-if="form" v-for="field in form.fields">
    <label for="" class="inside">{{ field.label }}</label>
    <span
      class="small-6 columns"
      :is="Fields[field.type]"
      :pointer="getPath(field.name)"
      :data="form.get(getPath(field.name))"
      :errors="form.errors"
      :source="field.source"
      :config="field.config"
      :help="field.help"
      @input="set"
    ></span>
  </span>
</div>

</template>

<script>
import * as Fields from './formfields'

export default {
  name: 'FormBuilder',
  props: [ 'form', 'parent' ],
  data () {
    return {
      Fields
    }
  },
  methods: {
    getPath (fieldname) {
      if (fieldname == null) {
        return this.parent == null ? '' : this.parent
      } else {
        return this.parent == null ? fieldname : this.parent + '.' + fieldname
      }
    },
    // adds a repeatable, generating empty objects from forms
    clone (fieldName, fieldIndex) {
      // when cloning check if we're cloning a fieldset or a single repeatable (with multiple values)

      // make sure the content field is able to receive data
      if (!this.form.collection[fieldName]) {
        this.$set(this.form.collection, fieldName, [])
      }

      // Fieldset (we have a fields subset)- get the fields
      if (this.form[fieldIndex].fields.length) {
        let dataObject = Object.create({})
        this.form[fieldIndex].fields.forEach((field) => {
          dataObject[field.name] = null
          if (field.fields.length) {
            // @TODO this should become recursive
            console.log('clone sub')
          }
        })
        this.form.collection[fieldName].push(dataObject)

      // Single Field - keep old data and make it an array
      } else {
        if (!Array.isArray(this.form.collection[fieldName])) {
          this.$set(this.form.collection, fieldName, [this.form.collection[fieldName]])
        }
        this.form.collection[fieldName].push('')
      }
    },
    value (field, index) {
      return this.form.get(field, index)
    },
    // sets a value
    set (data, index) {
      this.$emit('set', {value: data.value, pointer: data.pointer, index: index})
    },
    disk (cb) {
      this.$emit('disk', cb)
    },
    // collapse a structure
    collapse (item, collapsed) {
      this.$set(item, 'isCollapsed', collapsed)
    },
    // remove branch
    unlink (field, index) {
      this.form.collection[field.name].splice(index, 1)
    }
  }
}
</script>
