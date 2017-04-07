<template lang="pug">
div(v-if="data")
  p.control(v-for="(item, index) in source")
    input.radio(
      type="radio",
      @change="$emit('input', {pointer: pointer, value: data.data})",
      v-model="data.data",
      :value="index"
    )
    label.radio {{ item }}
</template>

<script>
// @TODO source moved from data.source to it's own property, check if that works
export default {
  name: 'Radio',
  props: ['data', 'pointer', 'source'],
  data () {
    return {
      selected: null
    }
  }
}
</script>
