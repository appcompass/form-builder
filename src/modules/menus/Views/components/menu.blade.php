@include('menus::components.VueSortable')

<template id="menu">
  <ul class="menu">
    <li
      class="menu__item"
      v-draggable-for="(index, item) in menu.items"
      track-by="id"
      :options="options"
    >
      <i class="handle fa fa-arrows"></i>
      @{{ item.title }}

      <div class="item-options pull-right" style="color: #fff">
        <a href v-if="item.children.length && !item.collapsed" @click="collapse(index, true)"><i class="fa fa-minus-square-o"></i></a>
        <a href v-if="item.collapsed" @click="collapse(index, false)"><i class="fa fa-plus-square-o"></i></a>
        <a href v-if="!item.edit" @click="editItem(index, true)"><i class="fa fa-pencil-square-o"></i></a>
        <a href v-if="item.edit === true" @click="editItem(index, false)"><i class="fa fa-chevron-up"></i></a>
        <a href @click="unlink(index)"><i class="fa fa-trash-o"></i></a>
      </div>

      <form class="form-horizontal bucket-form" v-if="item.edit === true">
        <div class="form-group">
          <label for="" class="col-sm-4 control-label">Label</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" v-model="item.title">
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-4 control-label">Alt</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" v-model="item.alt">
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-4 control-label">Url</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" v-model="item.url">
          </div>
        </div>
        <div class="form-group">
          <label for="" class="col-sm-4 control-label">Required Permission</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" v-model="item.req_perm">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-8 col-sm-offset-4">
            <div class="checkbox">
              <label class="control-label">
                <input type="checkbox" v-model="item.new_tab">
                New Tab
              </label>
            <div class="checkbox">
            </div>
              <label class="control-label">
                <input type="checkbox" v-model="item.clickable">
                Clickable
              </label>
            </div>
          </div>
        </div>
        <div class="form-group" v-if="item.type === 'Link'">
          <label for="" class="col-sm-4 control-label">Content</label>
          <div class="col-sm-8">
            <textarea class="form-control" id="" cols="30" rows="10" v-model="item.content"></textarea>
          </div>
        </div>

      </form>

      <menu v-if="!item.collapsed" :menu="{items: item.children, id: menu.id, deletions: menu.deletions}" :options="options"></menu>
    </li>
    <li v-if="menu.items.length === 0" class="item--empty"></li>
  </ul>
</template>

<script>
Vue.config.debug = false

Vue.component('menu', {
  template: '#menu',
  props: ['menu', 'options'],
  methods: {
    unlink: function(index) {
      // @NOTE only delete items with 'navigatable_type' set, housekeeping
      if (this.menu.items[index].navigatable_type) {
        this.menu.deletions.push(this.menu.items[index].id)
      }
      this.menu.items.splice(index, 1)
    },
    editItem: function(index, value) {
      this.$set('menu.items[' + index + '].edit', value)
    },
    collapse: function(index, value) {
      this.$set('menu.items[' + index + '].collapsed', value)
    }
  }
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
.menu__item .handle {
  margin-right: 10px;
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
  border-bottom: 1px solid #333;
}
.item-options a {
  margin-left: 10px;
}
.item-options a:hover {
  color: #1FB5AD;
}
</style>