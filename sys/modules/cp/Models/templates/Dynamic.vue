<template lang="jade">
div
  p.control
    label.label Model
    input.input(v-model="data.sourceable_type", disabled="true")
  p.control
    label.label Related Field
    input.input(v-model="data.related_field")
  p.control
    label.label Select
    span.icon.is-small(@click="addSelect()")
      i.fa.fa-plus
    span(v-for="(select, index) in data.criteria.select")
      input.input(v-model="data.criteria.select[index]")
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
  },
  methods: {
    addSelect () {
      if (!this.data.criteria.select) {
        this.$set(this.data.criteria, 'select', [])
      }
      this.data.criteria.select.push('')
    }
  }
}
</script>
