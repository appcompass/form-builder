@extends('ui::layouts.basic_admin_panel')

{{-- TABS ON PANEL HEADER --}}
@section('header')
    <p>NAVIGATION MANAGER</p>
@stop

<!-- NAVMENUS -->
@section('body')
<section id="menu-builder">
  <header class="panel-heading tab-bg-dark-navy-blue ">
    <ul class="nav nav-tabs">
      <li class="navmenu-tab" v-for="(index, menu) in menus" :class="{active: isActive(index) }">
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
          <pre>@{{ menu.items | json }}</pre>
        </div>
      </div>
    </div>
  </section>
</section>
@stop


<script>
(function(vue) {
  new Vue({
    el: '#menu-builder',
    data: {
      menus: {!! $menus !!},
      status: {
        active: 0
      }
    },
    methods: {
      active: function(menuIndex) {
        console.log(menuIndex)
        this.status.active = menuIndex
      },
      isActive: function(menuIndex) {
        return this.status.active === menuIndex
      }
    }
  })
})(Vue)
</script>