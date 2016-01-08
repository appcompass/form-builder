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

    <div class="tab-content" id="navmanager">

        <div
            v-for="navmenu in navmenus"
            class="tab-pane col-lg-8 col-lg-offset-2 col-md-12"
            v-bind:class="{'active': $index == 0 }"
            id="@{{ navmenu.name }}"
        >

            <ol
                dropzone="copy"
                class="sortable"
                href="/websites/{{ $website->id }}/navigation"
                v-nested-sortable
                data-navmenu="@{{ navmenu.name }}"
            >

                <navitem
                    v-for="item in navmenu.items"
                    :navitem="item"
                    :children="navmenu.children"
                ></navitem>

            </ol>

            {{-- <pre>@{{ navmenu | json }}</pre> --}}

            <div>
                <a
                    :disabled="hierarchy === undefined"
                    class="btn btn-danger pull-right"
                    @click="restore"
                >Cancel</a>
                <a
                    :disabled="hierarchy === undefined"
                    class="btn btn-primary pull-right"
                    @click="store"
                >Save</a>
            </div>

        </div>
    </div>

{{-- closing panel opened in parent template --}}
</div>
</div>
</section>

{{-- ITEMS TO ADD --}}
<section class="panel" id="sources-wrapper">
    <div class="panel-heading">Pages</div>
    <div class="panel-body">
        <ol class="inline-draggable sortable-source">
            <navitem
                v-for="item in items"
                :navitem="item"
                draggable="true"
                v-draggable
            ></navitem>
        </ol>
    </div>
</section>

{{-- UTILS --}}
<section class="panel" id="utils-wrapper">
    <div class="panel-heading">UTILS</div>
    <div class="panel-body">
        <ol class="inline-draggable sortable-source">
            <navitem
                v-for="item in utils"
                v-draggable
                :navitem="item"
            ></navitem>
        </ol>
    </div>
</section>

@stop

<template id="navitem">
    <li
        id="navitem_@{{ navitem.id }}"
        data-id="navitem_@{{ navitem.id }}"
    >
        <div>
            <i class="handle fa fa-arrows"></i>
            <span class="title">@{{ navitem.label }}</span>
            <div class="tools pull-right">
                <i class="fa fa-cog"></i>
                <i class="fa fa-trash-o"></i>
            </div>
            <img src="https://placehold.it/120x120" alt="">
            <footer>@{{ navitem.label }}</footer>

        </div>

        <ol
            v-if="navitem.has_content"
        >
            <navitem
                v-for="item in childItems"
                :navitem="item"
            ></navitem>
        </ol>
    </li>
</template>

@section('footer.scripts')

<script src="/assets/ui/js/jquery.nestedSortable.js"></script>

<script>

    Vue.config.debug = true

    var content = {
        navmenus: {!! $navmenus->toJson() !!},
        items: {!! json_encode($items) !!},
        utils: {!! json_encode($utils) !!},
        hierarchy: undefined,
        initialHierarchy: undefined
    }

    var navitem = Vue.extend({
        template: '#navitem',
        props: ['navitem', 'children'],
        computed: {
            /* discovers element's children */
            childItems: function() {
                var navitemId = this.navitem.navigatable_id;
                var item = undefined;
                if (this.children) {
                    for (var i = 0; i < this.children.length; i++) {
                        if (this.children[i].id === navitemId) {
                            item = this.children[i].items;
                        }
                    }
                }

                return item;
            }
        }
    })

    Vue.component('navitem', navitem);

    Vue.directive('nested-sortable', {
        bind: function() {
            var vm = this.vm;
            var $el = $(this.el);

            $el.nestedSortable({
                handle: '.handle',
                items: 'li',
                toleranceElement: '> div',
                placeholder: 'placeholder',
                maxLevels: 2,

                stop: function(e, ui) {
                    var hierarchy = $el.nestedSortable('toHierarchy', {attribute: 'data-id'});
                    var navmenu = $($(this)[0]);

                    vm.$emit('sortableStop', {hierarchy: hierarchy, navmenu: navmenu.attr('data-navmenu')});
                }
            });

        }
    })

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
        data: content
    })

    var UtilsSources = new Vue({
        el: '#utils-wrapper',
        data: content
    })

    var NavManager = new Vue({
        el: "#navmanager",
        data: content,
        ready: function() {
            this.resource = this.$resource("/websites/{{ $website->id }}/navigation/{/id}");
            this.initialHierarchy = this.navmenus;
        },
        http: {
            root: '/root',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        },
        methods: {
            restore: function() {
                document.location.reload(true);
            },
            store: function() {
                console.log(this.hierarchy)
                this.resource.save({
                    navmenu_name: this.navmenu,
                    hierarchy: this.hierarchy
                });
            }
        },
        events: {
            sortableStop: function(data) {
                this.hierarchy = JSON.stringify(data.hierarchy);
                this.navmenu = data.navmenu;
            }
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

    li input[type="text"] { border: 0; background: transparent; }
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