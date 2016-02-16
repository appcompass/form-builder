<section class="panel">
    <header class="panel-heading">
        {{ $meta->edit->heading or '' }}
    </header>

    <div class="panel-body row">

        <div class="col-sm-9 col-sm-offset-1">
            <p class="clearfix">You can manage your redirects from here. The webserver is gonna automatically restart when you save.</p>

            <table class="table table-hover general-table dataTable" id="app">
                <thead v-if="redirects.length">
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="redirect in redirects">
                        <td>
                            <div v-if="!redirect.editMode">@{{ redirect.from }}</div>
                            <div v-else>
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="redirect.from"
                                    placeholder="The URL you want to redirect."
                                    value="@{{ redirect.from }}"
                                >
                            </div>
                        </td>

                        <td>
                            <div v-if="!redirect.editMode">@{{ redirect.to }}</div>
                            <div v-if="redirect.editMode">
                                <input
                                    class="form-control"
                                    type="text"
                                    v-model="redirect.to"
                                    placeholder="The new URL users will be redirected to."
                                    value="@{{ redirect.to }}"
                                >
                            </div>
                        </td>

                        <td>
                            <div v-if="!redirect.editMode">@{{ redirect.type }}</div>
                            <div v-if="redirect.editMode">
                                <select v-model="redirect.type">
                                    <option v-for="type in types" v-bind:value="type.name">@{{ type.name }}</option>
                                </select>
                            </div>
                        </td>

                        <td>
                            <a
                                href
                                class="btn btn-primary btn-xs"
                                v-if="!redirect.editMode"
                                v-on:click.prevent="redirect.editMode = !!!redirect.editMode"
                            >
                                Edit
                            </a>
                            <a
                                href
                                class="btn btn-success btn-xs"
                                v-if="redirect.editMode"
                                v-on:click.prevent="redirect.editMode = !!!redirect.editMode"
                            >
                                Done
                            </a>
                            <a
                                href
                                class="btn btn-danger btn-xs"
                                v-on:click.prevent="destroy(redirect)"
                            >
                                <i class="fa fa-trash"> Delete</i>
                            </a>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4">
                            <div class="pull-right">
                                <a
                                    href
                                    class="btn btn-success"
                                    v-on:click.prevent="add()"
                                > + Add</a>
                                <a class="btn pull-right btn-primary" v-on:click.prevent="store">Save</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.7.0/vue-resource.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.16/vue.js"></script>

<script>

    var data = {!! json_encode($redirects) !!};

    data.forEach(function(item) {
        item.editMode = false;
    })

    var Vue = new Vue({
        el: '#app',
        data: {
            redirects: data,
            types: [
                {name: '301'},
                {name: '300'},
            ]
        },
        ready: function() {
            this.resource = this.$resource("{{ $meta->base_url }}");
        },
        methods: {
            add: function() {
                this.redirects.push({from: '', to: '', type: '301', editMode: true});
            },
            store: function() {
                this.resource.save({
                    redirects: this.redirects
                }).then(function(response) {
                    console.log(response)
                }, function(error) {
                    console.log(error);
                })
            },
            destroy: function(item) {
                this.redirects.$remove(item);
            }
        },
        http: {
            root: '/root',
            headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }

    })

</script>
