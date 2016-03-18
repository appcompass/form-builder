<div class="leftside-navigation">
    <ul class="sidebar-menu" id="nav-accordion">
        <li
            v-for="item in nav"
            v-bind:class="{'sub-menu': item.children}"
        >
            <a v-bind:href="item.props.link.href" v-on:click="toggle($index)">
                <i class="fa fa-@{{ item.props.icon }}"> </i> @{{ item.label }}
            </a>

            <ul class="sub" v-bind:class="{ 'collapsed': visible($index) }" v-if="item.children">
                <li v-for="sub_item in item.children">
                    <a v-bind:href="sub_item.props.link.href"> <i class="fa fa-@{{ sub_item.props.icon }}"> </i> @{{ sub_item.label }} </a>
                </li>
            </ul>
        </li>
    </ul>

</div>

<script>

    (function(Vue) {

        var data = {
            nav: {!! json_encode($nav) !!}
        }

        new Vue({
            el: '#nav-accordion',
            data: {
                nav: data.nav,
                sections: []
            },
            methods: {
                toggle: function(index) {
                    if (this.sections.indexOf(index) === -1) {
                        this.sections.push(index);
                    } else {
                        this.sections.$remove(index);
                    }
                },
                visible: function(index) {
                    return this.sections.indexOf(index) > -1;
                }
            },

        })
    })(Vue)

</script>

<style>
    .collapsed {display: none; }
</style>