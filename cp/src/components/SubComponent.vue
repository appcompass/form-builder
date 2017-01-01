<template lang="jade">
div
  h1 Sub Navigation
  ul
    li
      router-link(:to="{name: 'sub', params: {model: 'posts', id: $route.params.id, sub: 'comments'}}") Comments
    li
      router-link(:to="{name: 'sub', params: {model: 'users', id: $route.params.id, sub: 'comments'}}") User
</template>

<script>
export default {
  name: 'SubComponent',
  created () {
    console.log()
  }
}

</script>
