<template lang="jade">
footer.footer
  .container
    .content.has-text-centered
      p Built with
        span.icon.is-small
          i.fa.fa-heart
        |  by
        a(href="https://www.p3in.com")  Plus Three Interactive.
      p The source code is licensed
        a(href="http://opensource.org/licenses/mit-license.php")  MIT.
        |  The website content is licensed
        a(href="http://creativecommons.org/licenses/by-nc-sa/4.0/")  CC ANS 4.0
      p
        a.icon(href="https://github.com/plus3interactive/")
          i.fa.fa-github
</template>

<script>
export default {
  name: 'Footer'
}
</script>

<style lang="sass" scoped>
i.fa.fa-heart
  color: red
</style>
