<template>
<span>
  <p>Check one or more services you&rsquo;ll likely require for your project: </p>
  <div class="checkbox" v-for="field, key in source">
    <input type="checkbox" :id="key" :checked="isChecked(key)" @change="toggle(key)">
    <label :for="key">{{ field }}</label>
  </div>
  <div class="hide">
    <label for="" class="inside">Specify</label>
    <input type="text">
  </div>
</span>
</template>
<script>
export default {
  name: 'Checkboxes',
  props: ['pointer', 'data', 'label', 'errors', 'help', 'source'],
  data () {
    return {
      checked: []
    }
  },
  methods: {
    isChecked (field) {
      return this.checked.indexOf(field) > -1
    },
    set (event) {
      console.log(event.target.value)
    },
    toggle (field) {
      let index = this.checked.indexOf(field)

      if (index > -1) {
        this.checked.splice(index, 1)
      } else {
        this.checked.push(field)
      }

      this.$emit('input', {pointer: this.pointer, value: this.checked})
    }
  }
}
</script>
