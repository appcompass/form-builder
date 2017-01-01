<template lang="jade">
textarea.textarea(@input="$emit('input', {value: $event.target.value, pointer: pointer})")
</template>

<script>
export default {
  name: 'Formtext',
  props: ['pointer', 'data']
}
</script>
