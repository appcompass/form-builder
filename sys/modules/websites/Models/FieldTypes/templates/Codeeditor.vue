<template lang="jade">
div#editor
  span(v-html="data")
</template>

<script>
// import ace from https://github.com/ajaxorg/ace

export default {
  name: 'Codeeditor',
  props: ['pointer', 'data'],
  data () {
    return {
    }
  },
  beforeDestroy () {
  },
  mounted () {
  }
}
</script>

<style lang="styl">
</style>
