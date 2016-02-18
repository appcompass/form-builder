@extends('layouts/basic_admin_panel')

@section('header')
    {{ $meta->index->heading or '' }}
@stop

@section('body')
    <div class="col-sm-9 col-sm-offset-1" id="groups-manager">
        <p class="page-header"><b>@{{ user.full_name }}</b> Current Groups</p>
        <ul>
            <li v-for="group in owned">
                @{{ group.label }}
                <a href class="btn btn-xs btn-danger" v-on:click.prevent="remove(group)"><i class="fa fa-trash-o"></i></a>
            </li>
        </ul>

        <p class="page-header">Groups Available</p>
        <ul>
            <li v-for="group in avail">
                @{{ group.label }}
                <a href class="btn btn-xs btn-success" v-on:click.prevent="add(group)"><i class="fa fa-plus"></i></a>
            </li>
        </ul>

        <div class="tools pull-right">
            <a class="btn btn-primary" v-on:click.prevent="store()">Save</a>
        </div>
    </div>


@stop

@section('footer.scripts')
    <script>
        (function(Vue) {

            var Vue = new Vue({
                el: '#groups-manager',
                data: {
                    user: {!! json_encode($users) !!},
                    owned: {!! json_encode($users->permissions) !!},
                    avail: {!! json_encode($available_perms) !!}
                },
                ready: function() {
                    this.resource = this.$resource("{{ $meta->base_url }}");
                },
                methods: {
                    add: function(group) {
                        var found = this.owned.some(function(el) {
                            return el.id === group.id;
                        })

                        if (!found) {
                            return this.owned.push(group);
                        }
                    },
                    remove: function(group) {
                        return this.owned.$remove(group);
                    },
                    store: function(){
                        this.resource.save({
                            permissions: this.owned
                        }).then(function(response) {
                            console.log(response)
                        }, function(error) {
                            console.error(error);
                        })
                    }
                },
                http: {
                    root: '/root',
                    headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }
            });
        })(Vue)
    </script>
@stop