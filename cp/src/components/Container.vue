<template lang="jade">
div.page-container(v-if="container.section.type === 'container'")
  Container(v-if="container.children", v-for="sub in container.children", :container="sub", :level="level + 1")
div.element(v-else, @click="editSection(container.id)")
  a {{ container.section.name }}
</template>

<script>
import Modal from './Modal'

export default {
  name: 'Container',
  props: [ 'container', 'level' ],
  data () {
    return {
      modal: Modal
    }
  },
  methods: {
    editSection (id) {
      this.$http.get(process.env.API_SERVER + 'pages/' + this.$route.params.id + '/content/' + id)
        .then(response => {
          console.log(response.data.collection.section.form.fields)
          // @TODO building data object is gonna be interesting
          this.modal.show(response.data.collection.section.form.fields, this.link, (result) => {
            console.log(result)
          })

          console.log(response)
        })
    }
  }
}
</script>

<style lang="sass">
.page-container
  border: 1px solid #333
  flex-grow: 1

.flex
  display: flex
  flex-direction: column

.element
  flex-grow: 1
  background: #ddd
  padding: 1rem
  min-height: 8rem
  &:hover
    cursor: pointer
    background: #ada
    color: #333

.full
  width: 100%
</style>
