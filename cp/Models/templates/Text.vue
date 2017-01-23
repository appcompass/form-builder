<template lang="jade">
div
  textarea.textarea(@input="$emit('input', {value: $event.target.value, pointer: pointer})", :value="data")
</template>

<script>
export default {
  name: 'Formtext',
  props: ['pointer', 'data']
}
</script>