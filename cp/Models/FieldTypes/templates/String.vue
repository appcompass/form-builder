<template lang="jade">
p.control
  label.label {{ label }}
  input.input(
    type="text",
    @input="$emit('input', {value: $event.target.value, pointer: pointer})",
    :value="data"
  )
</template>

<script>
export default {
  name: 'string',
  props: ['pointer', 'data', 'label']
}
</script>
