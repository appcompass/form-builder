<template lang="jade">
div
  .columns
    .page.column.is-6
      Container(v-for="container in collection.data", :container="container", @edit="edit")
    .column.is-6
      a.button.is-primary(@click="store") Save
      FormBuilder(:form="form", :content="content")
</template>

<script>
import Container from '../Container'
import FormBuilder from '../FormBuilder'
import swal from 'sweetalert'
import _ from 'lodash'

export default {
  name: 'PageEditorList',
  components: { Container, FormBuilder },
  props: ['collection'],
  data () {
    return {
      form: null,
      content: null,
      id: null // id being edited
    }
  },
  methods: {
    value (fieldName) {
      return _.get(this.dataObject, fieldName)
    },
    edit (id) {
      this.id = id
      this.$http.get(process.env.API_SERVER + 'pages/' + this.$route.params.id + '/content/' + id)
        .then(response => {
          this.form = response.data.collection.form
          // @TODO backend sends in an empty array instead of object in case no content is present
          if (Array.isArray(response.data.collection.content)) {
            this.content = Object.create({})
          } else {
            this.content = response.data.collection.content
          }
        })
    },
    store () {
      this.$http.put(process.env.API_SERVER + 'pages/' + this.$route.params.id + '/content/' + this.id, this.content)
        .then(response => {
          swal({title: 'Success', text: 'BOOM! Done!', type: 'success'})
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
