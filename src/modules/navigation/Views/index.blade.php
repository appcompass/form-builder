@extends('layouts/basic_admin_panel')

{{-- TABS ON PANEL HEADER --}}
@section('header')
    <header class="panel-heading tab-bg-dark-navy-blue ">
        <ul class="nav nav-tabs">

        @foreach ($navmenus as $navmenu)
            <li @if ($navmenu->id === $navmenus[0]->id) class="active" @endif>
                <a data-toggle="tab" class="no-link" href="#{{ $navmenu->name }}">{{ str_replace('_', ' ', $navmenu->name) }}</a>
            </li>
        @endforeach

        </ul>
    </header>
@stop

{{-- NAVMENUS --}}
@section('body')

    {{-- Navmanager --}}
    <div class="tab-content" id="navmanager">

        {{-- Tab Panel --}}
        <div
            v-for="navmenu in navmenus"
            class="tab-pane col-lg-8 col-lg-offset-2 col-md-12"
            v-bind:class="{'active': $index == 0 }"
            id="@{{ navmenu.name }}"
        >
            <p>@{{ navmenu.label }}</p>
            <Navmenu
                :navmenu="navmenu"
            ></Navmenu>

        </div>
    </div>

{{-- closing panel opened in parent template --}}
</div>
</div>
</section>

{{-- DRAGGABLE ITEMS --}}
<section class="panel" id="sources-wrapper">
    <div class="panel-heading">Pages</div>
    <div class="panel-body">
        <ol class="inline-draggable">
            <Navitem
                v-for="item in items"
                :navitem="item"
                v-draggable
                @dblclick="addItem(item)"
            ></Navitem>
        </ol>
    </div>
</section>

{{-- DRAGGABLE ITEMS - UTILS --}}
<section class="panel" id="utils-wrapper">
    <div class="panel-heading">UTILS</div>
    <div class="panel-body">
        <ol class="inline-draggable">
            <Navitem
                v-for="item in utils"
                :navitem.sync="item"
                v-draggable
                @dblclick="addItem(item)"
            ></Navitem>
        </ol>
    </div>
</section>

@stop

<template id="navmenu">
    <div>
        <ol
            class="sortable"
            href="/websites/{{ $website->id }}/navigation"
        >
            <Navitem
                v-if="content.legth != ''"
                v-for="item in content"
                :navitem.sync="item"
            />
        </ol>

        <pre>@{{ content | json }}</pre>

        {{-- Save / Cancel --}}
        <div class="pull-right">
            <a
                class="btn btn-primary"
                @click="serialize"
            >Serialize</a>
            <a
                class="btn btn-danger"
                @click="restore"
            >Cancel</a>
            <a
                class="btn btn-success"
                @click="store(content)"
            >Save</a>
        </div>
    </div>
</template>

<template id="navitem">
    <li
        data-id="navitem_@{{ navitem.id }}"
    >
        <div>
            <i class="handle fa fa-arrows"></i>
            <span class="title"><input type="text" v-model="navitem.label"></span>
            <div class="tools pull-right">
                <i class="fa fa-cog" @click="showOptions = !showOptions"></i>
                <i class="fa fa-trash-o" @click="destroy"></i>
            </div>
            <img src="https://placehold.it/120x120" alt="">
            <footer>@{{ navitem.pivot.label }} @{{ navitem.label }}</footer>
            <span class="row" v-if="showOptions" style="background: #ccc;">
                <div class="col-md-10 col-offset-md-1">
                    <label for="" class="col-md-4">Url</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" v-model="navitem.url">
                    </div>
                </div>

                <div class="col-md-10 col-offset-md-1">
                    <label for="" class="col-md-4">New Tab</label>
                    <div class="col-md-8">
                        <input type="checkbox" v-model="navitem.new_tab">
                    </div>
                </div>
            </span>
        </div>

        <ol
            v-if="navitem.children != ''"
        >
            <navitem
                v-for="item in navitem.children"
                :navitem.sync="item"
            ></navitem>
        </ol>
    </li>
</template>

@section('footer.scripts')

<script src="/assets/ui/js/jquery.nestedSortable.js"></script>

<script>

    // Vue.config.debug = true

    var content = {
        navmenus: {!! $navmenus->toJson() !!},
        items: {!! json_encode($items) !!},
        utils: {!! json_encode($utils) !!},
        content: []
    }

    /**
     *  Parses content of a navmenu
     *
     */
    function parseContent(navmenu, parent) {
        var newContent = [];
        parent = parent || null;

        navmenu.items.forEach(function(item) {

            var children = mapFromArray(navmenu.children, 'id');
            console.log(item);
            var newItem = {
                id: item.id,
                // label: item.label,
                label: item.pivot.label || item.label,
                url: item.pivot.url || item.url,
                new_tab: item.pivot.new_tab || item.new_tab,
                children: [],
                parent: parent ? parent.id : null
            };

            if (children && children[item.navigatable_id] !== undefined) {
                newItem.children = parseContent(children[item.navigatable_id], item);
            }

            newContent.push(newItem)
        });

        return newContent
    }

    /**
     * Creates a map out of an array be choosing what property to key by
     *
     */
    function mapFromArray(array, prop) {
        var map = {};
        for (var i=0; i < array.length; i++) {
            map[ array[i][prop] ] = array[i];
        }
        return map;
    }

    var Navmenu = Vue.extend({
        template: '#navmenu',
        props: ['navmenu'],

        data: function() {
            return {
                content: [],
                hierarchy: undefined,
                initialState: undefined
            }
        },

        ready: function() {
            this.resource = this.$resource("/websites/{{ $website->id }}/navigation/");

            var $el = $(this.$el).children('ol').first();
            var vm = this;
            var received = false;

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
                    vm.store(hierarchy, true, function() { item.parent('ol').children('.ui-draggable').remove(); });
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

                    if (!pretend) {
                        this.initialState = this.content;
                    }

                    if (cb) {
                        cb(response);
                    }

                }, function(error) {
                    console.error(error)
                });
            },
            serialize: function() {
                console.log(JSON.stringify(this.content));
            }
        },

        events: {
            'destroyNavitem': function(data) {
                var $el = $(this.$el).children('ol').first();
                var hierarchy = $el.nestedSortable('toHierarchy', {attribute: 'data-id'});
                this.store(hierarchy, true)
            },
            'addElement': function(ele) {
                console.log(ele)
            }
        },

        http: {
            root: '/root',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }
    })

    var Navitem = Vue.extend({
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
            },
            addToBottom: function() {
                this.$dispatch('addElement', this.navitem);
            }
        }
    })

    Vue.component('Navitem', Navitem);
    Vue.component('Navmenu', Navmenu);

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

    var NavSources = new Vue({
        el: '#sources-wrapper',
        data: content,
        methods: {
            addItem: function(item) {
                console.log(item)
            }
        }
    })

    var UtilsSources = new Vue({
        el: '#utils-wrapper',
        data: content
    })

    var NavManager = new Vue({
        el: "#navmanager",
        data: content,
        ready: function() {
            this.items = mapFromArray(content.items, 'id');
        }
    });

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

    li input[type="text"] { border: 0; background: transparent; min-width: 25rem; border-bottom: 1px solid transparent; }
    li input[type="text"]:focus { border-bottom: 1px solid #666; background: transparent; }
    li button { background: #fff; border: 0; }

    .placeholder { border: 1px dashed #aaa; height: 25px; background: rgba(238, 238, 238, 0.1); width: 100%;}
    .helper { background: rgba(238, 238, 238, 0.8); height: 25px; }

    .inline-draggable  { height: 120px; }
    .inline-draggable li { min-height: 120px; position: relative; width: 120px !important; float: left; margin: 10px;}
    .inline-draggable li div .handle { position: absolute; right: -15px; top: -6px;}
    .inline-draggable .tools, .inline-draggable .title {display: none;}
    .inline-draggable li div footer { display: block; color: #fff; padding: 5px 0; text-align: center; line-height: 20px; 100%; width: 100%; position: absolute; bottom: 0;left: 0;right: 0; background: rgba(128, 128, 128, 0.7); }

</style>

@stop