<template lang="jade">
.columns
  .page.column.is-6
    Container(v-for="container in collection.data.data", :container="container", :level="level", @edit="edit")
  .column.is-6
    span(v-if="form", v-for="field in form")
      label.label {{ field.label }}
      span(
        v-bind:is="Components[field.type]",
        v-bind:pointer="field.name"
        v-bind:data="value(field.name)"
        v-bind:value="value(field.name)"
      )

</template>

<script>
import Container from '../Container'
import * as Components from '../Components'
import _ from 'lodash'
// import Modal from '../Modal'

export default {
  name: 'PageEditorList',
  components: { Container },
  props: ['collection'],
  data () {
    return {
      Components,
      form: null,
      // modal: Modal,
      level: 0
    }
  },
  methods: {
    set (data) {
      _.set(this.dataObject, data.pointer, data.value)
    },
    value (fieldName) {
      return _.get(this.dataObject, fieldName)
    },
    edit (id) {
      this.$http.get(process.env.API_SERVER + 'pages/' + this.$route.params.id + '/content/' + id)
        .then(response => {
          // console.log(response.data.collection.section.form.fields)
          this.form = response.data.collection.section.form.fields

          console.log(this.form)

          // @TODO building data object is gonna be interesting
          // this.modal.show(response.data.collection.section.form.fields, this.link, (result) => {
            // console.log(result)
          // })
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
