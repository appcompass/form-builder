<template lang="jade">
table.table.is-striped

  thead
    th(v-for="field in forms.list.fields", nowrap)
      .columns
        .column.is-11
          input.input.is-small(
            v-model="$parent.search[field.name]",
            v-if="forms.edit.indexOf(field.id) > -1",
            :placeholder="field.label",
            @keyup="$parent.applyFilter"
          )
          span.is-primary(
            v-else
            @click="$parent.toggleSorter(field)",
            :class="{'is-active': $parent.sorters[field.name], 'asc': $parent.sorters[field.name] === 'ASC', 'desc': $parent.sorters[field.name] === 'DESC', 'is-sortable': field.config.sortable}"
          ) {{ field.label }}
        .column.is-1
          span.filter-toggle.fa.is-small.pull-right(
            v-if="field.config.searchable",
            style="margin-top: 5px; font-size: 1rem"
            @click="$parent.toggleEdit(field)",
            :class="{'fa-search': forms.edit.indexOf(field.id) === -1, 'fa-close': forms.edit.indexOf(field.id) > -1}"
          )
    th
      span Actions

  tbody(:class="{'is-opaque': $parent.loading}", v-if="collection.data.data.length")
    tr(v-for="row in collection.data.data")
      td(v-for="field in forms.list.fields")
        p(v-html="value(field.name, row)")
      td
        .control.is-grouped

          p.control
            router-link.button.is-small(:to="{name: 'edit', params: {model: $route.fullPath.slice(1).split('/').join('_'), id: row.id}}")
              span.icon.is-small
                i.fa.fa-edit
              span Edit
          p.control
            a.button.is-small.is-outlined.is-danger(@click="$parent.remove(row.id)")
              span.icon.is-small
                i.fa.fa-times
              span Delete

  tbody(v-else, :class="{'is-opaque': $parent.loading}")
    tr
      td.has-text-centered(:colspan="forms.list.fields.length + 1")
        .notification.is-danger
          .title No results found.
</template>

<script>
// @TODO
//  - only pass list form
import _ from 'lodash'

export default {
  name: 'TableList',
  props: [ 'forms', 'collection' ],
  data () {
    return {
      _
    }
  },
  methods: {
    value (name, row) {
      return _.get(row, name)
    }
  }
}
</script>
