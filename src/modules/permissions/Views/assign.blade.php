@extends('layouts/basic_admin_panel')

@section('header')
    {{ $meta->edit->heading or '' }}
@stop

@section('body')
    <div class="col-sm-9 col-sm-offset-1" id="permissions-manager">
        <p class="page-header">Currently Owned</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Label</th>
                    <th>Description</th>
                    <th>Permissions</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="single in owned">
                    <td>@{{ single.label }}</td>
                    <td>@{{ single.description }}</td>
                    <td>
                        <div v-if="single.permissions">
                            <ul>
                                <li v-for="perm in single.permissions">@{{ perm.label }}</li>
                            </ul>
                        </div>
                    </td>
                    <td>
                        <a
                            href
                            v-on:click.prevent="remove(single)"
                            class="btn btn-xs btn-danger"
                        ><i class="fa fa-trash-o"> </i></a>
                    </td>
                </tr>
            </tbody>
        </table>

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
                <tr v-for="single in avail">
                    <td>@{{ single.label }}</td>
                    <td>@{{ single.description }}</td>
                    <td>
                        <a
                            href
                            v-on:click.prevenr="add(single)"
                            class="btn btn-xs btn-success"
                        >
                            <i class="fa fa-plus"></i>
                        </a>

                    </td>
                </tr>
            </tbody>
        </table>

        <div class="tools pull-right">
            <a class="btn btn-primary" v-on:click.prevent="store()">Save</a>
        </div>
    </div>
@stop

@section('footer.scripts')

<script>
    (function(Vue) {

        var data = {
            owned: {!! json_encode($owned) !!},
            avail: {!! json_encode($avail) !!},
            owner: {!! json_encode($owner) !!}
        };

        var Vue = new Vue({
            el: '#permissions-manager',
            data: data,

            ready: function() {
                this.resource = this.$resource("{{ $meta->base_url }}");
            },

            methods: {
                add: function(item) {

                    var found = this.owned.some(function(el) {
                        return el.id === item.id;
                    })

                    if (!found) {
                        this.owned.push(item);
                    }

                },

                remove: function(item) {
                    this.owned.$remove(item);
                },

                store: function() {
                    this.resource.save({
                        owned: this.owned
                    }).then(function(response) {
                    }, function(error) {
                        console.error(error);
                    })
                },

                http: {
                    root: '/root',
                    headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
            }
        })

    })(Vue)
</script>
@stop