<template id="menu-element">
<span>

    <i class="handle fa fa-arrows"></i>
    @{{ item.title }} @{{ $index }}
    <menu v-if="item.children.length" :menu="{items: item.children}"></menu>
</span>
</template>

<script>
var MenuElement = Vue.extend({
    template: '#menu-element',

    props: ['item']
})
</script>