<template lang="jade">
.columns
  .page.column.is-6
    Container(v-for="container in collection.data.data", :container="container", :level="level", @edit="edit")
  .column.is-6
    FormBuilder(:form="form", @add="add")
</template>

<script>
import Container from '../Container'
import FormBuilder from '../FormBuilder'
import _ from 'lodash'

export default {
  name: 'PageEditorList',
  components: { Container, FormBuilder },
  props: ['collection'],
  data () {
    return {
      form: null,
      level: 0
    }
  },
  methods: {
    add (field) {
      this.form.push(field)
    },
    set (data) {
      _.set(this.dataObject, data.pointer, data.value)
    },
    value (fieldName) {
      return _.get(this.dataObject, fieldName)
    },
    edit (id) {
      this.$http.get(process.env.API_SERVER + 'pages/' + this.$route.params.id + '/content/' + id)
        .then(response => {
          this.form = response.data.collection
        })
    }
  }
}
</script>

<style lang="sass">
.page
  position: relative
  display: flex
  flex-direction: column
</style>
