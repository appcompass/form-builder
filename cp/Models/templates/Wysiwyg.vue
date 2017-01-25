<template lang="jade">
div#editor
  <h2>One Ring to Rule The Mall</h2>
  <p><a href="http://en.wikipedia.org/wiki/One_Ring">http://en.wikipedia.org/wiki/One_Ring</a></p>
  <p><br/></p>
  <p>Three Rings for the <em>Elven-kings</em> under the sky,</p>
  <p>Seven for the <u>Dwarf-lords</u><span> in halls of stone,</p>
  <p>Nine for <u>Mortal Men</u>, doomed to die,</p>
  <p>One for the <u>Dark Lord</u> on his dark throne.</p>
  <p><br/></p>
  <p>In the Land of Mordor where the Shadows lie.</span></p>
  <p>One Ring to <strong>rule</strong> them all, One Ring to <strong>find</strong> them,</p>
  <p>One Ring to <strong>bring</strong> them all and in the darkness <strong>bind</strong> them.</p>
  <p>In the Land of Mordor where the Shadows lie.</p>

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
        modules: {
          toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block']
          ]
        }
      },
      editor: null
    }
  },
  mounted () {
    this.editor = new Quill(this.$el, this.options)
    this.editor.on('text-change', (delta) => {
      this.$emit('input', {
        value: this.editor.getText(), pointer: this.pointer
      })
    })
  }
}
</script>

<style lang="styl">
@import "~quill/assets/snow"
.editor
  min-height: 10rem
</style>
