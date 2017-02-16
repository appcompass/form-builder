<template lang="jade">
textarea.textarea(@input="$emit('input', {value: $event.target.value, pointer: pointer})", :value="data")
</template>

<script>
export default {
  name: 'Text',
  props: ['pointer', 'data']
}
</script>
