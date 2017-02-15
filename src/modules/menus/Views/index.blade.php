@extends('ui::layouts.basic_admin_panel')

@section('header')
    <p>NAVIGATION MANAGER</p>
@stop

@section('body')
<section id="menu-builder">
  <header class="panel-heading tab-bg-dark-navy-blue ">
    <ul class="nav nav-tabs">
      <li class="navmenu-tab" v-for="(menuIndex, menu) in menus" :class="{active: isActive(menuIndex)}">
        <a
          data-toggle="tab"
          class="no-link"
          href="#@{{ menu.name }}"
          @click="active(menuIndex)"
        >@{{ menu.name }}
          <span v-if="menu.id != null" class="menu__delete" @click="deleteMenu(menuIndex)"><i class="fa fa-times-circle"></i></span>
        </a>
      </li>
      <li class="pull-right">
        <a href="" @click="addMenu" class="btn btn-primary"><i class="fa fa-plus-square" style="color: #ddd"></i></a>
      </li>
    </ul>
  </header>

  <section class="panel">
    <div class="panel-body">
      <div class="tab-content">
        <div
          v-for="(menuIndex, menu) in menus"
          class="tab-pane col-sm-12"
          id="@{{ menu.name }}"
          :class="{'active': isActive(menuIndex)}"
        >
          {{-- if menu.id exists the menu has been stored and we're editing it  --}}
          <div class="row" v-if="menu.id">

            <div class="col-sm-4">
              <h2>Pages
                <span class="pull-right">
                  <a v-if="!status.pages.collapsed" @click="status.pages.collapsed = true"><i class="fa fa-minus-square"></i></a>
                  <a v-else @click="status.pages.collapsed = false"><i class="fa fa-plus-square"></i></a>
                </span>
              </h2>

              <ul class="menu" v-if="!status.pages.collapsed">
                <li>
                  <input type="text" class="form-control" v-model="search" placeholder="Search page">
                </li>
                <li
                  class="menu__item"
                  v-draggable-for="item in pages | filterBy search in 'title'"
                  track-by="id"
                  @dblclick="addItem(menuIndex, item)"
                  :options="{group: { name: 'menu', put: false, pull: 'clone' }}"
                > @{{ item.title }} </li>
              </ul>

              <h2>Links
                <span class="pull-right">
                  <a class="btn btn-xs btn-warning" v-if="!status.addingLink" @click="status.addingLink = true">Add Link</a>
                  <a class="btn btn-xs" v-if="status.addingLink" @click="status.addingLink = false">Cancel</a>
                  <a v-if="!status.links.collapsed" @click="status.links.collapsed = true"><i class="fa fa-minus-square"></i></a>
                  <a v-if="status.links.collapsed" @click="status.links.collapsed = false"><i class="fa fa-plus-square"></i></a>
                </span>
              </h2>

              <form class="form-horizontal bucket-form" v-if="status.addingLink">
                <div class="form-group">
                  <label for="" class="col-sm-4 control-label">Label</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" v-model="link.title">
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-4 control-label">Url</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" v-model="link.url">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-8 col-sm-offset-4">
                    <div class="checkbox">
                      <label class="control-label">
                        <input type="checkbox" v-model="link.new_tab">
                        New Tab
                      </label>
                    <div class="checkbox">
                    </div>
                      <label class="control-label">
                        <input type="checkbox" v-model="link.clickable">
                        Clickable
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="" class="col-sm-4 control-label">Content</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" v-model="link.content"></textarea>
                  </div>
                </div>
                <div class="footer">
                  <div class="pull-right">
                    <button type="button" class="btn btn-primary" @click="storeLink(menuIndex)">Store</button>
                  </div>
                </div>
              </form>

              <ul class="menu" v-if="!status.links.collapsed">
                <li
                  class="menu__item"
                  v-draggable-for="item in links"
                  track-by="id"
                  @dblclick="addItem(menuIndex, item)"
                  :options="{group: { name: 'menu', put: false, pull: 'clone' }}"
                > @{{ item.title }}
                  <span class="pull-right">
                    <a href @click="deleteLink(item)">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </span>
                </li>
              </ul>

            </div>

            <div class="col-sm-8">
              <h2>Menu: @{{ menu.name }}</h2>
              <menu :menu="menu" :options="options"></menu>

              <div class="pull-right">
                <button class="btn" @click="undoEdits(menuIndex)">Cancel</button>
                <button class="btn btn-primary" @click="save(menuIndex)">Save</button>
              </div>
            </div>

          </div>

          <div class="row" v-if="menu.id == null">
            <form class="form-horizontal bucket-form">
              <div class="form-group">
                <label for="" class="col-sm-4 control-label">Name</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" v-model="menu.name">
                </div>
              </div>
              <div class="pull-right">
                <button type="button" class="btn" @click="cancelMenu(menuIndex)">Cancel</button>
                <button class="btn btn-primary" type="submit" @click="create(menuIndex)">Create</button>
              </div>
            </form>
          </div>

      </div>
    </div>
  </section>

</section>

@stop

@include('menus::components.menu')

<script>
var menus = {!! $menus !!}
var pages = {!! $pages !!}
var links = {!! $links !!}

Vue.use(VueResource)

Vue.filter('match', function (value, input) {
  return input ? value.filter(function(item) {
     return item.genre === input ? value : null;
  }) : value;
});

new Vue({
  el: '#menu-builder',
  data: {
    menus: menus,
    originals: {
      menus: null
    },
    pages: pages,
    links: links,
    options: {"handle": '.handle', "group": {"name": 'menu'}, "animation": 300 },
    link: {title: null, url: null, new_tab: false, clickable: true, content: null },
    status: {
      links: {collapsed: false },
      pages: {collapsed: false },
      active: 0,
      addingLink: false
    }
  },
  created: function() {
    this.originals.menus = _.cloneDeep(this.menus, this.originals.menus)
  },
  events: {
    unlink: function(menuIndex, itemIndex) {

      console.log(menuIndex, itemIndex)
      // this.menus[menuIndex].deletions.push(itemIndex)
    }
  },
  methods: {
    save: function(index) {
      var menu = this.menus[index]
      var payload = {
        id: menu.id,
        menu: {
          menu: menu.items,
          deletions: menu.deletions
        }
      }
      this.$http.put('/websites/' + menu.website + '/menus/' + menu.id, payload)
        .then(function(response) {
          console.log(response.data)
          if (response.status === 200) {
            this.menus = response.data
            sweetAlert({title: 'Menu Updated', text: 'Navigation Menu updated succesfully', type: 'success', html: true, });
          }
        })
    },
    create: function(index) {
      var menu = this.menus[index]
      var payload = {
        name: menu.name
      }
      this.$http.post('/websites/' + menu.website + '/menus/', payload)
        .then(function(response) {
          if (response.status === 200) {
            this.menus = response.data.menus
            this.active(index)
          }
        })
    },
    undoEdits: function(menuIndex) {
      this.menus.$set(menuIndex, _.cloneDeep(this.originals.menus[menuIndex]))
    },
    storeLink: function(menuIndex) {
      var vm = this
      // @TODO could replace with event instead of passing menuIndex every time
      vm.$http.post('/websites/' + menu.website + '/link', vm.link)
        .then(function(response) {
          vm.menus[menuIndex].items.push(response.data.menuitem)
          vm.links.push(response.data.menuitem)
          vm.status.addingLink = false
        })
    },
    deleteLink: function(link) {
      var vm = this
      // @NOTE links are not website specific
      sweetAlert({title: 'Remove Item', text: 'Are you sure you want to delete from the current Menu?', type: 'warning', showCancelButton: true }, function() {
        vm.$http.delete('/websites/' + vm.menus[0].website + '/link/' + link.id)
          .then(function(response) {
            vm.links.$remove(link)
          })
      })
    },
    addItem: function(menuIndex, item) {
      this.menus[menuIndex].items.push(item)
    },
    active: function(menuIndex) {
      this.status.active = menuIndex
    },
    isActive: function(menuIndex) {
      return this.status.active === menuIndex
    },
    cancelMenu: function(menuIndex) {
      this.menus.splice(menuIndex, 1)
      this.active(this.menus.length - 1)
    },
    addMenu: function() {
      this.menus.push({
        id: null,
        deletions: [],
        items: [],
        name: 'New Menu',
        website: this.menus[0].website
      })
      this.active(this.menus.length - 1)
    },
    deleteMenu: function(menuIndex) {
      var vm = this
      sweetAlert({
        title: 'Delete Menu',
        text: 'Are you sure you want to delete from the current Menu? Deletion is permanent.',
        type: 'warning',
        showCancelButton: true }
        , function() {
          var menu = vm.menus[menuIndex]
          vm.$http.delete('/websites/' + menu.website + '/menus/' + menu.id)
            .then(function(response) {
              if (response.status === 200) {
                sweetAlert({title: 'Menu Deleted', text: 'Navigation Menu succesfully deleted.', type: 'success', html: true, });
                this.menus.splice(menuIndex, 1)
              }
            }).catch(function() {
              sweetAlert({title: 'Error', text: 'There was an error deleting the Menu.', type: 'error', html: true, });
            })
        })
    }
  }
})
</script>

<style>
.sources .item--empty {
  display: none !important;
}
.navmenu-tab .menu__delete {
  display: none;
  position: absolute;
  top: 3px;
  right: 3px;
  background: transparent !important;
}
.navmenu-tab:hover .menu__delete {
  display: block;
}
</style>