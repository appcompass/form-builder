@include('menus::components.VueSortable')
@include('menus::components.menu-element')

<template id="menu">
<ul class="menu">
  <li
    class="menu__item"
    v-draggable-for="item in menu.items"
    track-by="$index"
    :options="options"
  >
      <i class="handle fa fa-arrows"></i>
      @{{ item.title }}
      <menu :menu="{items: item.children}" :options="options"></menu>
  </li>
  <li v-if="menu.items.length === 0" class="item--empty"></li>
</ul>
</template>

<script>
Vue.config.debug = false

Vue.component('menu', {
  template: '#menu',
  components: { MenuElement },
  props: ['menu', 'options'],
  methods: {}
})

</script>

<style>
ul.menu {
  margin-top: 0.3rem;
  list-style-type: none;
  display: inline-block;
  width: 100%;
}
.menu__item > ul.menu {
  margin-top: 1rem;
}
.menu > .menu__item {
  background: #eee;
  border: 1px solid #fff;
  margin: 0.5rem;
  padding: 1rem;
}
.item--empty {
  display: inline-block;
  min-height: 2rem;
  width: 100%;
  border-bottom: 1px solid thistle;
}
</style>