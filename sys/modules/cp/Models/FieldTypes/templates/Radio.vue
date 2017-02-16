<template lang="jade">
div
  p.control(v-for="(item, index) in data.source")
    input.radio(
      type="radio",
      @change="$emit('input', {pointer: pointer, value: data.data})",
      v-model="data.data",
      :value="index"
    )
    label.radio {{ item }}
</template>

<script>
export default {
  name: 'Radio',
  props: ['data', 'pointer'],
  data () {
    return {
      selected: null
    }
  }
}
</script>
