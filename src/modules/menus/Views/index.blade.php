@extends('ui::layouts.basic_admin_panel')

@section('header')
    <p>NAVIGATION MANAGER</p>
@stop

@section('body')
<section id="menu-builder">
  <header class="panel-heading tab-bg-dark-navy-blue ">
    <ul class="nav nav-tabs">
      <li class="navmenu-tab" v-for="(index, menu) in menus" :class="{active: isActive(index)}">
        <a data-toggle="tab" class="no-link" href="#@{{ menu.name }}" @click="active(index)">
          @{{ menu.name }}
        </a>
      </li>
    </ul>
  </header>

  <section class="panel">
    <div class="panel-body">
      <div class="tab-content">
        <div class="tab-pane col-lg-8 col-lg-offset-2 col-md-12" v-for="(index, menu) in menus" id="@{{ menu.name }}" :class="{'active': isActive(index)}">
          <menu :menu="menu" :options="options"></menu>
        </div>
      </div>
    </div>
  </section>


  <section class="panel">
    <div class="panel-body sources">
      <ul class="menu">
        <li
          class="menu__item"
          v-draggable-for="item in sources.items"
          track-by="$index"
          :options="{group: { name: 'menu', pull: 'clone', put: false }}"
        > @{{ item.title }}
      </ul>
    </div>
  </section>

  <pre>
    @{{ menus | json }}
  </pre>

</section>

@stop

@include('menus::components.menu')

<script>
var menus = {!! $menus !!}

new Vue({
  el: '#menu-builder',
  data: {
    menus: menus,
    options: {"handle": '.handle', "group": {"name": 'menu'}, "animation": 200 },
    sources: {
      items: [
        { title: 'foo', id: 110, children: [] },
        { title: 'bat', id: 111, children: [] }
      ],
    },
    status: {
      active: 0
    }
  },
  events: {
    updateMenu: function(event) {
      console.log(this)
    },
    add: function(event) {
      console.log('add')
      // console.log(event.item.__vfrag__.scope.item)
      // event.to.removeChild(event.item)
      // event.to.__vue__.menu.push(event.item.__vfrag__.scope.item)
    }
  },
  watch: {
    menus: function(nv) {
      console.log(nv)
      // nv.forEach(function(menu) {
      //   menu.items.forEach(function(item) {
      //     console.log('-- ' + item.title )
      //   })
      // })
    }
  },
  methods: {
    active: function(menuIndex) {
      this.status.active = menuIndex
    },
    isActive: function(menuIndex) {
      return this.status.active === menuIndex
    }
  }
})
</script>

<style>
.sources .item--empty {
  display: none !important;
}
</style>