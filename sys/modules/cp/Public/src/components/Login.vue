<template lang="jade">
.columns
  .column.is-half.is-offset-one-quarter
    p.is-danger(v-if="error") Login Error, fucko!
    p.control.has-icon
      input.input(type="email", placeholder="Email", v-model="email", @keydown="error = false", @keyup.enter="login")
      span.icon.is-small
        i.fa.fa-envelope
    p.control.has-icon
      input.input(type="password", placeholder="Password", v-model="password", @keyup.enter="login", @keydown="error = false")
      span.icon.is-small
        i.fa.fa-lock
    p.control
      button.button.is-success(@click="login") Login
</template>

<script>
import auth from './Auth.js'

export default {
  name: 'Login',
  data () {
    return {
      email: null,
      password: null,
      error: false
    }
  },
  methods: {
    login () {
      auth.login(this, this.email, this.password)
    }
  }
}
</script>
