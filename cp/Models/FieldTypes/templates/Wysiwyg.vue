<template lang="jade">
div#editor
  span(v-html="data")
</template>

<script>
import Quill from 'quill'

export default {
  name: 'Wysiwig',
  props: ['pointer', 'data'],
  data () {
    return {
      options: {
        theme: 'snow',
        editor: null,
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block']
          ]
        }
      }
    }
  },
  beforeDestroy () {
    // console.log(this.editor.destroy())
    this.editor = null
  },
  mounted () {
    this.editor = new Quill(this.$el, this.options)
    this.editor.on('text-change', (delta) => {
      this.$emit('input', {
        value: this.editor.root.innerHTML,
        pointer: this.pointer
      })
    })
  }
}
</script>

<style lang="styl">
@import "~quill/assets/snow"
.ql-container
  height: initial
  min-height: 10rem
</style>
