<template lang="jade">
.columns.is-multiline
  .column.is-4(v-for="gallery in collection.data.data")
    .card
      .card-image
        figure.image.is-4by3
          img(src="https://placehold.it/400x300")
      .card-content
        .media
          .media-content
            p.title.is-4 {{ gallery.name }}
            p.subtitle.is-6 {{ gallery.user.email }}

        .content
          ul
            li Attr1: Val
            li Attr2: Val
            li Attr3: Val
          p Lorem ipsum dolor sit amet, consectetur adipisicing elit. Non officia suscipit quos.
          small 08:38 AM
            .pull-right
              router-link.button.is-small.is-primary(:to="{name: 'edit', params: {model: 'galleries', id: gallery.id}}") Edit

</template>

<script>
export default {
  props: ['collection', 'forms'],
  name: 'CardList'
}
</script>

<style lang="sass">

</style>
