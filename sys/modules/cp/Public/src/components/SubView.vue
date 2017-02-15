<template lang="pug">
.section
  {{ data }}
</template>

<script>
export default {
  name: 'subview',
  data () {
    return {
      data: {}
    }
  },
  created () {
    this.fetch(this.$route.path).then((response) => {
      this.data = response.data
    })
  },
  methods: {
    fetch (endpoint) {
      return this.$http.get('/api' + endpoint)
    }
  }
}
</script>
