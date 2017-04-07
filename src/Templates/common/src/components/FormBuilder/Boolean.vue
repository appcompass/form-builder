<template lang="pug">
input.checkbox(
  type="checkbox",
  v-bind:checked="data"
  @click="toggle"
)
</template>

<script>
export default {
  name: 'boolean',
  props: [ 'pointer', 'data' ],
  mounted () {
    this.checked = this.data
  },
  methods: {
    toggle () {
      this.checked = !this.checked
      this.$emit('input', {value: this.checked, pointer: this.pointer})
    }
  }
}
</script>
