<template lang="jade">
div
  .control
    label.checkbox
      input(type="checkbox", v-model="edit")
      |  Change Password
  .control(v-if="edit")
    input.input(type="password", v-model="pass1", placeholder="Password", @input="input")
  .control(v-if="edit")
    input.input(type="password", v-model="pass2", placeholder="Password Again", @input="input")
</template>

<script>
export default {
  name: 'secret',
  data () {
    return {
      edit: false,
      pass1: undefined,
      pass2: undefined
    }
  },
  methods: {
    input () {
      if (this.pass1 === this.pass2) {
        console.log('Ok!')
        this.$emit('input', this.pass1)
      }
    }
  }
}
</script>
