@extends('layouts/basic_admin_panel')

@section('header')
    {{ $meta->edit->heading or '' }}
@stop

@section('body')
    <div class="col-sm-9 col-sm-offset-1" id="permissions-manager">
        <p class="page-header">Currently Owned - <b>{{ $owner->label or $owner->full_name }}</b></p>
        <table class="table" v-if="owned.length">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Description</th>
                    <th v-if="owned[0] && owned[0].permissions">Permissions</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="single in owned">
                    <td>@{{ single.label }}</td>
                    <td>@{{ single.description }}</td>
                    <td v-if="single.permissions">
                        <ul>
                            <li v-for="perm in single.permissions">@{{ perm.label }}</li>
                        </ul>
                    </td>
                    <td>
                        <a
                            href
                            v-on:click="remove(single)"
                            class="btn btn-xs btn-danger"
                        ><i class="fa fa-trash-o"> </i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        <p v-else><b>Nothing at the moment.</b></p>

        <p class="page-header">Available</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="single in avail"
                    v-bind:class="{disabled: single.isOwned}"
                >
                    <td>@{{ single.label }}</td>
                    <td>@{{ single.description }}</td>
                    <td>
                        <a
                            href
                            v-on:click="add(single)"
                            class="btn btn-xs btn-success"
                        >
                            <i class="fa fa-plus"></i>
                        </a>

                    </td>
                </tr>
            </tbody>
        </table>

        <div class="tools pull-right">
            <a
                href="#"
                class="btn btn-primary"
                v-on:click.prevent="store()"
            >Save</a>
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