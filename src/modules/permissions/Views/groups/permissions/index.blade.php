@extends('layouts/basic_admin_panel')

@section('header')
    {{ $meta->edit->heading or '' }}
@stop

@section('body')
    <div class="col-sm-9 col-sm-offset-1" id="permissions-manager">
        <p class="page-header">Group's Permissions</p>
        <ul>
            <li v-for="permission in owned">
                @{{ permission.label }}
                <a href v-on:click.prevenr="remove(permission)" class="btn btn-xs btn-danger">-</a>
            </li>
        </ul>

        <p class="page-header">Available Permissions</p>
        <ul>
            <li v-for="permission in avail">
                @{{ permission.label }}
                <a href v-on:click.prevenr="add(permission)" class="btn btn-xs btn-success">+</a>
            </li>
        </ul>

        <div class="tools pull-right">
            <a class="btn btn-primary" v-on:click.prevent="store()">Save</a>
        </div>
    </div>
@stop

@section('footer.scripts')

<script>
    var data = {
        owned: {!! json_encode($groups->permissions) !!},
        avail: {!! json_encode($permissions) !!}
    };

    var Vue = new Vue({
        el: '#permissions-manager',
        data: data,

        ready: function() {
            this.resource = this.$resource("{{ $meta->base_url }}");
        },

        methods: {
            add: function(permission) {

                var found = this.owned.some(function(el) {
                    return el.id === permission.id;
                })

                if (!found) {
                    this.owned.push(permission);
                }

            },

            remove: function(item) {
                this.owned.$remove(item);
            },

            store: function() {
                this.resource.save({
                    permissions: this.owned
                }).then(function(response) {
                    console.log(response)
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
</script>
@stop