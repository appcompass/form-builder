<template>
<span>
  <label class="inside">{{ label }}</label>
  <textarea
    class="textarea"
    :class="{'is-danger': errors.get(pointer)}"
    @input="$emit('input', {value: $event.target.value, pointer: pointer})"
    :value="data"
    rows="6"
  ></textarea>
</span>
</template>

<script>
export default {
  name: 'Text',
  props: ['pointer', 'data', 'label', 'errors', 'help']
}
</script>

<style scoped>
	.is-danger {
		border: 1px solid red !important;
	}
</style>
