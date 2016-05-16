<template id="formbuilder">
        <div class="form-group" v-for="field in form.fields">
            <label class="col-sm-3 control-label" v-bind:for="field.name"> @{{ field.label }} </label>
            <div class="col-sm-9">
                <div v-bind:is="field.type" v-bind:field="field"></div>
            </div>
        </div>
</template>

<template id="text">
    <input
        class="form-control"
        type="text"
        v-model="field.value"
        v-bind:placeholder="field.placeholder"
    >
</template>

<template id="textarea">
    <textarea
        v-bind:name="field.name"
        v-model="field.value"
        rows="10"
        class="form-control"
        v-bind:placeholder="field.placeholder"
    ></textarea>
</template>

<template id="dropdown">
    <select
        v-bind:name="field-name"
        v-model="field.value"
    >
        <option v-bind:value="option.value" v-for="option in field.options">@{{ option.label }}</option>
    </select>
</template>

<script>

(function(Vue, window, sweetAlert) {

    window.FormBuilder = Vue.extend({
        template: '#formbuilder',
        props: ['form'],
        data: function() {
            return {}
        },
        methods: {},
        components: {
            text: Vue.component('text', {template: '#text', props: ['field'] }),
            dropdown: Vue.component('dropdown', {template: '#dropdown', props: ['field'] }),
            textarea: Vue.component('text-area', {
                template: '#textarea',
                props: ['field'],
                methods: {
                }
            }),
        }
    })
})(Vue, window, sweetAlert)
</script>
