<template>
  <div id="__nuxt">
    <component v-if="layout" :is="layout"></component>
  </div>
</template>

<script>
let layouts = {

  "_default": process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/layouts/default.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/layouts/default.vue'),

  "_public": process.BROWSER_BUILD ? () => System.import('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/layouts/public.vue') : require('/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/layouts/public.vue')

}

export default {
  head: {"titleTemplate":"%s - Plus 3 Interactive","script":[{"src":"https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"}],"link":[{"rel":"icon","type":"image/png","href":"/favicon.png"}],"meta":[{"charset":"utf-8"},{"http-equiv":"x-ua-compatible","content":"ie=edge"},{"name":"viewport","content":"width=device-width, initial-scale=1"},{"hid":"description","content":"Plus 3 Interactive, LLC"}]},
  data: () => ({
    layout: null,
    layoutName: ''
  }),
  methods: {
    setLayout (layout) {
      if (!layout || !layouts['_' + layout]) layout = 'default'
      this.layoutName = layout
      let _layout = '_' + layout
      if (typeof layouts[_layout] === 'function') {
        return this.loadLayout(_layout)
      }
      this.layout = layouts[_layout]
      return Promise.resolve(this.layout)
    },
    loadLayout (_layout) {
      return layouts[_layout]()
      .then((Component) => {
        layouts[_layout] = Component
        this.layout = layouts[_layout]
        return this.layout
      })
      .catch((e) => {
        if (this.$nuxt) {
          return this.$nuxt.error({ statusCode: 500, message: e.message })
        }
        console.error(e)
      })
    }
  }
}
</script>


<style src="~assets/css/main.css" lang="css"></style>

