@extends('ui::layouts.basic_admin_panel')

@section('header')
    Permissions for {{ $owner->label or $owner->full_name }}
@stop

@section('body')
    <div class="col-sm-9 col-sm-offset-1" id="permissions-manager">
        <table class="table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Description</th>
                    <th v-if="avail[0] && avail[0].permissions">Permissions</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="single in avail"
                >
                    <td v-bind:class="{disabled: single.isOwned}">@{{ single.label }}</td>
                    <td v-bind:class="{disabled: single.isOwned}">@{{ single.description }}</td>
                    <td v-if="single.permissions">
                        <ul>
                            <li v-for="perm in single.permissions">@{{ perm.label }}</li>
                        </ul>
                    </td>
                    <td>
                        <a
                            href="javascript:;"
                            v-on:click="toggle(single)"
                            class="btn btn-xs"
                            v-bind:class="{'btn-success': !single.isOwned, 'btn-danger': single.isOwned}"
                        >

                            <i
                                class="fa"
                                v-bind:class="{'fa-plus': !single.isOwned, 'fa-trash-o': single.isOwned}"
                            ></i>
                        </a>

                    </td>
                </tr>
            </tbody>
        </table>

        <div class="pull-right">
            <a
                href="javascript:;"
                class="btn btn-primary"
                v-on:click.prevent="store()"
            >
            <i class="fa fa-save"></i> Save</a>
        </div>
    </div>
@stop

@section('footer.scripts')

<style>
    .disabled {
        opacity: 0.5;
    }
</style>

<script>

    (function(Vue) {

        /// DATA INIT

        var data = {
            owned: {!! json_encode($owned) !!},
            avail: {!! json_encode($avail) !!},
            owner: {!! json_encode($owner) !!}
        };
        data.avail.forEach(function(item) {
            item.isOwned = false;
        })

        //
        //  VUE INSTANCE
        //
        var Vue = new Vue({
            el: '#permissions-manager',
            data: {
                avail: data.avail,
                owned: new Array()
            },
            methods: {
                add: add,
                remove: remove,
                toggle: toggle,
                store: store,
            },
            ready: function() {
                var self = this;
                self.resource = self.$resource("{{ $meta->base_url }}");

                self.avail.forEach(function(item) {
                    if (has(item, self.owned)) {
                        item.isOwned = true;
                    }
                })

                data.owned.forEach(function(item) {

                    var item = self.avail.find(function(el) {
                        return el.id === item.id;
                    })

                    self.add(item);
                })
            },

        });

        //
        //  METHODS
        //
        function toggle(item) {
            if (item.isOwned) {
                item.isOwned = false;
                return this.owned.$remove(item);
            }else{
                item.isOwned = true;
                return this.owned.push(item);
            }
        }

        function add(item) {

            if (!has(item, this.owned)) {
                item.isOwned = true;
                return this.owned.push(item);
            }

        }

        function remove(item) {
            item.isOwned = false;
            return this.owned.$remove(item);
        }

        function store() {
            this.resource.save({
                owned: this.owned
            }).then(function(response) {
                return true;
            }, function(error) {
                console.error(error);
            })
        }

        //
        // PRIVATE
        //

        function has(needle, hay, property) {

            property = undefined !== property ? property: 'id';

            return hay.some(function(el) {
                return el[property] === needle[property];
            })

        }
    })(Vue)
</script>
@stop
