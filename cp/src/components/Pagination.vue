<template lang="jade">
div.section.is-fullwidth(v-if="p.last_page")
  nav.pagination
    a.button(
      :class="{'is-disabled': p.current_page === 1}"
      @click="turn(-1)"
      :disabled="disabled"
    ) Previous
    a.button(
      @click="turn(1)",
      :class="{'is-disabled': p.last_page === p.current_page}"
      :disabled="disabled"
    ) Next

    ul(v-if="5 >= p.last_page")
      li(v-for="page in _.range(1, p.last_page + 1)")
        span
          a.button(
            @click="goto(page)",
            :class="{'is-primary': p.current_page === page}"
          ) {{ page }}

    ul(v-if="p.last_page > 5")
      li
        a.button(@click="goto(1)", :class="{'is-primary': p.current_page === 1}") 1
      li
        span(v-if="p.current_page > 3") ...
      li
        span(v-if="p.current_page > 3  && p.last_page > p.current_page + 2")
          a.button(@click="p.current_page--") {{ p.current_page - 1 }}
        span(v-if="3 >= p.current_page")
          a.button(@click="goto(2)", :class="{'is-primary': p.current_page === 2}") 2
        span(v-if="p.current_page > p.last_page - 3")
          a.button(@click="p.current_page = p.last_page - 3") {{ p.last_page - 3 }}

      li
        span(v-if="p.current_page > 3 && p.last_page > p.current_page + 2")
          a.button.is-primary {{ p.current_page }}
        span(v-if="3 >= p.current_page")
          a.button(@click="goto(3)", :class="{'is-primary': p.current_page === 3}") 3
        span(v-if="p.current_page > p.last_page - 3")
          a.button(@click="goto(p.last_page - 2)", :class="{'is-primary': p.current_page === p.last_page - 2}") {{ p.last_page - 2 }}

      li
        span(v-if="p.current_page > 3 && p.last_page > p.current_page + 2")
          a.button(@click="turn(1)") {{ p.current_page + 1 }}
        span(v-if="3 >= p.current_page")
          a.button(@click="goto(4)") 4
        span(v-if="p.current_page > p.last_page - 3")
          a.button(@click="goto(p.last_page - 1)", :class="{'is-primary': p.current_page === p.last_page - 1}") {{ p.last_page - 1 }}

      li
        span(v-if="p.last_page > p.current_page + 2") ...
      li
        a.button(@click="goto(p.last_page)", :class="{'is-primary': p.current_page === p.last_page}") {{ p.last_page }}

</template>

<script>
export default {
  name: 'pagination',
  props: ['p', 'disabled'],
  methods: {
    turn (amt) {
      if (this.p.current_page + amt > 0 && this.p.current_page + amt <= this.p.last_page) {
        this.p.current_page += amt
      }
    },
    goto (page) {
      this.p.current_page = page
    }
  }
}
</script>
