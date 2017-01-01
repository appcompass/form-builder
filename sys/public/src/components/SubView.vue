<template lang="jade">
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
      return this.$http.get('https://api.k1cc0.me/api' + endpoint)
    }
  }
}
</script>
