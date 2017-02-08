<template lang="jade">
div.section.is-fullwidth(v-if="p.last_page")
  nav.pagination.is-centered
    a.pagination-previous(
      :class="{'is-disabled': p.current_page === 1}"
      @click="turn(-1)",
      :disabled="disabled"
    ) Previous
    a.pagination-next(
      @click="turn(1)",
      :class="{'is-disabled': p.last_page === p.current_page}",
      :disabled="disabled"
    ) Next

    ul.pagination-list(v-if="p.last_page <= 10")
      li(v-for="page in pages")
        span
          a.pagination-link(
            @click="goto(page)",
            :class="{'is-current': p.current_page === page}"
          ) {{ page }}

    ul.pagination-list(v-if="p.last_page > 10")
      li
        a.pagination-link(@click="goto(1)", :class="{'is-current': p.current_page === 1}") 1
      li
        span.pagination-ellipsis(v-if="p.current_page > 3") &hellip;
      li
        span(v-if="p.current_page > 3  && p.last_page > p.current_page + 2")
          a.pagination-link(@click="p.current_page--") {{ p.current_page - 1 }}
        span(v-if="3 >= p.current_page")
          a.pagination-link(@click="goto(2)", :class="{'is-current': p.current_page === 2}") 2
        span(v-if="p.current_page > p.last_page - 3")
          a.pagination-link(@click="p.current_page = p.last_page - 3") {{ p.last_page - 3 }}

      li
        span(v-if="p.current_page > 3 && p.last_page > p.current_page + 2")
          a.pagination-link.is-current {{ p.current_page }}
        span(v-if="3 >= p.current_page")
          a.pagination-link(@click="goto(3)", :class="{'is-current': p.current_page === 3}") 3
        span(v-if="p.current_page > p.last_page - 3")
          a.pagination-link(@click="goto(p.last_page - 2)", :class="{'is-current': p.current_page === p.last_page - 2}") {{ p.last_page - 2 }}

      li
        span(v-if="p.current_page > 3 && p.last_page > p.current_page + 2")
          a.pagination-link(@click="turn(1)") {{ p.current_page + 1 }}
        span(v-if="3 >= p.current_page")
          a.pagination-link(@click="goto(4)") 4
        span(v-if="p.current_page > p.last_page - 3")
          a.pagination-link(@click="goto(p.last_page - 1)", :class="{'is-current': p.current_page === p.last_page - 1}") {{ p.last_page - 1 }}

      li
        span.pagination-ellipsis(v-if="p.last_page > p.current_page + 2") &hellip;
      li
        a.pagination-link(@click="goto(p.last_page)", :class="{'is-current': p.current_page === p.last_page}") {{ p.last_page }}

</template>

<script>
import _ from 'lodash'

export default {
  name: 'pagination',
  props: ['p', 'disabled'],
  computed: {
    pages () {
      return _.range(1, this.p.last_page + 1)
    }
  },
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
