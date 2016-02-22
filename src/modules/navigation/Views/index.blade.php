@extends('layouts/basic_admin_panel')

{{-- TABS ON PANEL HEADER --}}
@section('header')
    <p>NAVIGATION MANAGER</p>
@stop

<!-- NAVMENUS -->
@section('body')

<div id="navmanager">

    <!-- <pre>@{{ navmenus | json }}</pre> -->

    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">
            <li
                class="navmenu-tab"
                v-for="navmenu in navmenus"
                v-bind:class="{'active': checkifActive($index, navmenu) }"
                v-on:click="setActive(navmenu)"
            >
                <a
                    data-toggle="tab"
                    class="no-link"
                    href="#@{{ navmenu.name }}"
                >@{{ navmenu.label }}</a>
            </li>
        </ul>
    </header>

    <section class="panel">
        <div class="panel-heading">@{{ status.active.label }} </div>
        <div class="panel-body">

        {{-- Navmanager --}}

            <div class="tab-content">

                {{-- Tab Panel --}}
                <div
                    v-for="navmenu in navmenus"
                    class="tab-pane col-lg-8 col-lg-offset-2 col-md-12"
                    v-bind:class="{'active': $index == 0 }"
                    id="@{{ navmenu.name }}"
                >
                    <navmenu :navmenu="navmenu"/>
                </div>
            </div>
        </div>
    </section>

    <section class="panel">
        <div class="panel-heading">PAGES</div>
        <div class="panel-body">
            <nav-sources :items="items"/>
        </div>
    </section>

    <section class="panel">
        <div class="panel-heading">UTILS</div>
        <div class="panel-body">
            <utils-sources :utils="utils"/>
        </div>
    </section>

</div>

@stop

<!-- NAVMENU TEMPLATE -->
<template id="navmenu">
    <div>
        <ol
            class="sortable"
            href="/websites/{{ $website->id }}/navigation"
        >
            <nav-item
                v-if="content.legth != ''"
                v-for="item in content"
                :navitem.sync="item"
            />
        </ol>

        <a class="btn btn-primary" @click="jsonVisible = !jsonVisible">Toggle JSON Dump</a>

        <pre v-if="jsonVisible">@{{ content | json }}</pre>

        {{-- Save / Cancel --}}
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right clearfix row">
                    <a class="btn btn-danger" v-on:click="restore" >Cancel</a>
                    <a v-on:click="store(content)" class="btn btn-success">Save</a>
                </div>
            </div>
        </div>
    </div>
</template>

<!-- NAVITEM TEMPLATE -->
<template id="navitem">
    <li
        data-id="navitem_@{{ navitem.id }}"
        data-pivot="@{{ navitem.pivot }}"
        stlye="font-weight: bold"
    >
        <div>
            <i class="handle fa fa-arrows" ></i>
            <span class="title"><input type="text" v-model="navitem.label"></span>
            <div class="tools pull-right">
                <i class="fa fa-cog" @click="showOptions = !showOptions"></i>
                <i class="fa fa-trash-o" @click="destroy"></i>
            </div>
            <img src="https://placehold.it/120x120" alt="">
            <footer>@{{ navitem.label }}</footer>
            <span class="item-options row" v-if="showOptions">

                <div class="col-sm-10 col-sm-offset-1 well">

                    <div class="form-group">
                        <label for="url" class="control-label col-sm-4">Url</label>
                        <div class="col-sm-8">
                            <input
                                type="text"
                                class="form-control input-sm"
                                v-model="navitem.url"
                            >
                            <small class="help-block">What should this element point to?</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="url" class="control-label col-sm-4">New Tab</label>
                        <div class="col-sm-8">
                            <input
                                type="text"
                                class="form-control input-sm"
                                v-model="navitem.new_tab"
                            >
                            <small class="help-block">Check if link should open in a new tab</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="url" class="control-label col-sm-4">Permission Required</label>
                        <div class="col-sm-8">
                            <select class="form-control input-sm">
                                <option value="somethig">Create Galleries</option>
                            </select>
                            <small class="help-block">Select what permission is required to view this item. Leave blank for guest.</small>
                        </div>
                    </div>

                </div>
            </span>
        </div>

        <ol
            v-if="navitem.children != ''"
        >
            <nav-item
                v-for="item in navitem.children"
                :navitem.sync="item"
            />
        </ol>
    </li>
</template>

{{-- NAV SOURCES TEMPLATE --}}
<template id="nav-sources">
    <ol class="inline-draggable">
        <nav-item
            v-for="item in items"
            :navitem="item"
            v-draggable
            v-on:dblclick="add(item)"
        />
    </ol>
</template>

{{-- DRAGGABLE ITEMS - UTILS --}}
<template id="utils-sources">
    <ol class="inline-draggable">
        <nav-item
            v-for="item in utils"
            :navitem.sync="item"
            v-draggable
            v-on:dblclick="add(item)"
        />
    </ol>
</template>

@section('footer.scripts')

<script src="/assets/ui/js/jquery.nestedSortable.js"></script>

<script>
    (function(Vue) {

        Vue.config.debug = true;

        //
        //  NAVMENU
        //
        var Navmenu = Vue.extend({
            template: '#navmenu',
            props: ['navmenu'],
            data: function() {
                return {
                    content: [],
                    hierarchy: undefined,
                    initialState: undefined,
                    jsonVisible: false,
                }
            },
            ready: function() {
                var $el = $(this.$el).children('ol').first(),
                    vm = this;

                this.resource = this.$resource("/websites/{{ $website->id }}/navigation/");

                // LINK SORTABLE
                $el.nestedSortable({
                    handle: '.handle',
                    items: 'li',
                    helper: 'original',
                    toleranceElement: '> div',
                    placeholder: 'placeholder',
                    maxLevels: this.navmenu.max_depth || 2,

                    stop: function(e, ui) {
                        var hierarchy = $el.nestedSortable('toHierarchy', {attribute: 'data-id'});
                        var item = $(ui.item);

                        item.find('i').removeClass().addClass('fa fa-spinner fa-spin')

                        vm.store(hierarchy, true, function() {
                            item.parent('ol').children('.ui-draggable').remove();
                        });
                    }

                });

                vm.content = parseContent(vm.navmenu);
                vm.initialState = parseContent(vm.navmenu);

            },
            methods: {
                restore: function() {
                    this.content = this.initialState;
                },
                store: function(hierarchy, pretend, cb) {

                    pretend = pretend || false;
                    hierarchy = hierarchy || this.content;

                    this.resource.save({
                        navmenu_name: this.navmenu.name,
                        hierarchy: JSON.stringify(hierarchy),
                        pretend: pretend
                    }).then(function(response) {
                        this.content = parseContent(response.data);
                        if (!pretend) {this.initialState = this.content; }
                        if (cb) {cb(response); }
                    }, function(error) {});
                }
            },
            events: {
                destroyNavitem: function(data) {
                    var $el = $(this.$el).children('ol').first();
                    var hierarchy = $el.nestedSortable('toHierarchy', {attribute: 'data-id'});
                    this.store(hierarchy, true)
                },
                itemAdded: function(data) {
                    var navmenu = data.navmenu;
                    var item = data.item
                    if (navmenu.id === this.navmenu.id) {
                        this.content.push(item);
                    }
                }
            }
        })

        //
        // NAVITEM
        //
        var NavItem = Vue.extend({
            template: '#navitem',
            props: ['navitem'],
            data: function() {
                return {
                    showOptions: false
                }
            },
            methods: {
                destroy: function() {
                    var parent = $(this.$el).remove();
                    this.$dispatch('destroyNavitem', {item: this.navitem})
                }
            }
        })

        //
        //  DRAGGABLE
        //
        Vue.directive('draggable', {
            bind: function() {
                var vm = this.vm;
                var $el = $(this.el);

                $el.draggable({
                    connectToSortable: '.sortable',
                    helper: 'clone',
                    opacity: 0.2,
                    handle: '.handle',
                });
            }
        });

        //
        // NAVSOURCES
        //
        var NavSources = Vue.extend({
            template: '#nav-sources',
            props: ['items'],
            methods: {
                add: function(item) {
                    this.$dispatch('addItem', item);
                }
            }
        })

        //
        // UTILS
        //
        var UtilsSources = Vue.extend({
            template: '#utils-sources',
            props: ['utils'],
            methods: {
                add: function(item) {
                    this.$dispatch('addItem', item);
                }
            }
        })

        Vue.component('Navmenu', Navmenu);
        Vue.component('NavItem', NavItem);
        Vue.component('NavSources', NavSources);
        Vue.component('UtilsSources', UtilsSources);

        //
        // NAVMANAGER
        //
        new Vue({
            el: "#navmanager",
            data: {
                navmenus: {!! $navmenus->toJson() !!},
                items: {!! json_encode($navitems) !!},
                utils: {!! json_encode($utils) !!},
                status: {active: undefined}
            },
            ready: function() {
                this.items = mapFromArray(this.items, 'id');
                this.navmenus = mapFromArray(this.navmenus, 'id');
            },
            methods: {
                setActive: function(navmenu) {
                    this.status.active = navmenu;
                },
                checkifActive: function($index, navmenu) {
                    if ($index === 0) {
                        this.status.active = navmenu;
                        return true;
                    }
                    return false;
                }
            },
            events: {
                addItem: function(item) {

                    var newItem = {
                        id: item.id,
                        label: item.label === 'Empty' ? 'Rename Me' : item.label,
                        url: item.label === 'Empty' ? '' : item.url,
                        new_tab: false,
                        children: [],
                        pivot: null,
                        parent: null,
                    };

                    this.$broadcast('itemAdded', {navmenu: this.status.active, item: newItem});
                }
            },
            components: {
                Navmenu,
                NavItem,
                NavSources,
                UtilsSources
            }
        });

        ////////////// PRIVATE STUFF

        /**
         *  Parses content of a navmenu
         *  converting it to 'toHierarchy' output
         */
        function parseContent(navmenu) {
            var children = mapFromArray(navmenu.children, 'id');
            var build = function(navmenu) {
                var newContent = [];
                navmenu.navitems.forEach(function(item) {
                    var newItem = {
                        id: item.navigation_item_id,
                        label: item.label,
                        url: item.url,
                        new_tab: item.new_tab,
                        pivot: item.id,
                        linked_id: item.linked_id,
                        children: [],
                    };
                    if (children[newItem.linked_id] !== undefined) {
                        newItem.children = build(children[newItem.linked_id]);
                    }
                    newContent.push(newItem)
                });
                return newContent;
            }
            return build(navmenu);
        }

        /**
         * Creates a map out of an array be choosing what property to key by
         *
         */
        function mapFromArray(array, prop) {
            var map = {};
            if (array && array.length) {
                for (var i=0; i < array.length; i++) {
                    map[ array[i][prop] ] = array[i];
                }
            }
            return map;
        }

    })(Vue)

</script>


<style>
    ul, li { list-style: none; margin: 0; padding: 0; min-height: 25px;}
    .sortable, .draggable {min-height: 30px;}
    .sortable form { background: rgba(128, 128, 128, 0.4);}
    .sortable li { line-height: 30px; }
    li div { line-height: 30px;}
    li footer { display: none;}
    li.header > div { background: rgba(128, 128, 128, 0.4); text-align: center; font-weight: bold;}
    li.header > ol { padding: 0; }
    .sortable li ol { position: relative; }
    .sortable li ol a.add_subnav { position: absolute; botton: 0; right: 0;}
    .sortable li img { display: none; }
    .sortable li button { float: right; }
    .handle { float: left;  /*background: #ddd;*/  display: inline-block; line-height: 30px !important; width: 26px; margin-right: 10px; text-align: center; border-radius: 3px;}
    .handle:hover { cursor: pointer; background: #eee; }
    .title > input[type="text"] { border: 0; background: transparent; min-width: 25rem; border-bottom: 1px solid transparent; }
    .title > input[type="text"]:focus { border-bottom: 1px solid #666; background: transparent; }
    li button { background: #fff; border: 0; }
    .placeholder { border: 1px dashed #aaa; height: 25px; background: rgba(238, 238, 238, 0.1); width: 100%;}
    .helper { background: rgba(238, 238, 238, 0.8); height: 25px; }
    .inline-draggable  { height: 120px; }
    .inline-draggable li { min-height: 120px; position: relative; width: 120px !important; float: left; margin: 10px;}
    .inline-draggable li div .handle { position: absolute; right: -15px; top: -6px;}
    .inline-draggable .tools, .inline-draggable .title {display: none;}
    .inline-draggable li div footer { display: block; color: #fff; padding: 5px 0; text-align: center; line-height: 20px; 100%; width: 100%; position: absolute; bottom: 0;left: 0;right: 0; background: rgba(128, 128, 128, 0.7); }
    .item-options label { text-align: right; }
    .item-options {float: left; width: 100%; margin-top: 1rem;}
</style>

@stop