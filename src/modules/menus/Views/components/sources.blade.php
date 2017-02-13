<template id="sources">
<ul v-sortable="{ group: {name: 'items', pull: 'clone'}}">
    <li v-for="item in list" data-index="@{{$index}}">@{{ item.title }}</li>
</ul>
</template>

<script>
var Sources = Vue.extend({
    template: '#sources',
    props: ['list']
})
</script>