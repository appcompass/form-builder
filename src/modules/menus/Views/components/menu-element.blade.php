<template id="menu-element">
<li class="menu__item">
    <i class="handle fa fa-arrows"></i>
    @{{ item.title }}
    <menu :menu="item.children"></menu>
</li>
</template>

<script>
var MenuElement = Vue.extend({
    template: '#menu-element',
    props: ['item']
})
</script>