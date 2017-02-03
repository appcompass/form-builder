<template lang="jade">
div
  p.control
    label.label Model
    input.input(v-model="model")
  p.control
    label.label Limit
    input(v-model="limit")
  p.control
    label.label Sort
    input.input(v-model="sort")
  p.control
    label.label Join
    input.input(v-model="join")
  p.control
    label.label Where
    input.input(v-model="where")
</template>

<script>
export default {
  name: 'Dynamic',
  data () {
    return {
      model: null,
      limit: 0,
      sort: 'created_at ASC',
      join: null,
      where: null
    }
  }
}
</script>