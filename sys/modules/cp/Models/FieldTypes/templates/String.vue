<template lang="jade">
input.input(
  type="text",
  @input="$emit('input', {value: $event.target.value, pointer: pointer})",
  :value="data"
)
</template>

<script>
export default {
  name: 'string',
  props: ['pointer', 'data']
}
</script>
