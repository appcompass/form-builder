<template>
<div>
  <label for="" class="inside">{{ label }}</label>
  <input
    type="text"
    :value="data"
    class="input"
    :class="{'is-danger': errors.get(pointer)}"
    @input="$emit('input', {value: $event.target.value, pointer: pointer})"
  >
</div>
</template>

<script>
export default {
  name: 'string',
  props: ['pointer', 'data', 'label', 'errors', 'help']
}
</script>

<style scoped>
	.is-danger {
		border: 1px solid red !important;
	}
</style>
