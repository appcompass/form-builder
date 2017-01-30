<template lang="jade">
div.page
  Container(v-for="container in collection.data.data", :container="container", :level="level")
</template>

<script>
import Container from '../Container'

export default {
  name: 'PageEditorList',
  components: { Container },
  props: ['collection'],
  data () {
    return {
      level: 0
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
