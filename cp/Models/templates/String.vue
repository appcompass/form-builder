<template lang="jade">
input.input(
  type="text",
  @input="$emit('input', {value: $event.target.value, pointer: pointer})"
)
</template>

<script>
export default {
  name: 'string',
  props: ['pointer', 'data']
}
</script>
