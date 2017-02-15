<template lang="jade">
div.page-container(v-if="container.section.type === 'container'")
  Container(v-if="container.children", v-for="sub in container.children", :container="sub", @edit="edit")
div.element(v-else, @click="$emit('edit', container.id)")
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
    edit (id) {
      this.$emit('edit', id)
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
