<template lang="jade">
div
  p.control
    label.label Model
    input.input(v-model="data.sourceable_type", disabled="true")
  p.control
    label.label Related Field
    input.input(v-model="data.related_field")
  p.control
    label.label Limit
    input.input(type="number", v-model="data.criteria.limit")
  p.control
    label.label Sort
    span(v-for="(sort, index) in data.criteria.sort")
      input.input(v-model="data.criteria.sort[index]")
  p.control
    label.label Join
    input.input(v-model="data.criteria.join")
  p.control
    label.label Where
    input.input(v-model="data.criteria.where")
</template>

<script>
export default {
  name: 'Dynamic',
  props: ['data', 'pointer'],
  watch: {
    data: {
      deep: true,
      handler: function (nv) {
        this.$emit('input', nv)
      }
    }
  }
}
</script>
