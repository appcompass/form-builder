<template>
  <div>
    <nuxt-loading ref="loading"></nuxt-loading>
    <nuxt-child v-if="!nuxt.err"></nuxt-child>
    <nuxt-error v-if="nuxt.err" :error="nuxt.err"></nuxt-error>
  </div>
</template>

<script>
import Vue from 'vue'
import NuxtChild from './nuxt-child'
import NuxtError from '/Volumes/Media/Development/projects/web/api.p3in.com/cp/src/components/WwwPlus3interactiveCom/layouts/error.vue'
import NuxtLoading from './nuxt-loading.vue'

export default {
  name: 'nuxt',
  beforeCreate () {
    Vue.util.defineReactive(this, 'nuxt', this.$root.$options._nuxt)
  },
  created () {
    // Add this.$nuxt in child instances
    Vue.prototype.$nuxt = this
    // Add this.$root.$nuxt
    this.$root.$nuxt = this
    // Bind $nuxt.setLayout(layout) to $root.setLayout
    this.setLayout = this.$root.setLayout.bind(this.$root)
    // add to window so we can listen when ready
    if (typeof window !== 'undefined') {
      window.$nuxt = this
    }
    // Add $nuxt.error()
    this.error = this.$root.error
  },
  
  mounted () {
    this.$loading = this.$refs.loading
  },
  watch: {
    'nuxt.err': 'errorChanged'
  },
  methods: {
    errorChanged () {
      if (this.nuxt.err && this.$loading) {
        if (this.$loading.fail) this.$loading.fail()
        if (this.$loading.finish) this.$loading.finish()
      }
    }
  },
  
  components: {
    NuxtChild,
    NuxtError,
    NuxtLoading
  }
}
</script>
