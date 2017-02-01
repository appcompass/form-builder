<template>
  <div v-if="data" class="section-solution solution-intro">
    <div class="row">
      <div class="medium-8 medium-centered columns">
        <h1>{{data.title}}</h1>
        <div v-html="data.description"></div>
        <ul class="blue-list list-centered" v-if="data.link_format == 'ul'">
          <li v-for="link in data.links"><nuxt-link :to="link.href">{{link.text}}</nuxt-link></li>
        </ul>
        <ol class="blue-list list-centered" v-if="data.link_format == 'ol'">
          <li v-for="link in data.links"><nuxt-link :to="link.href">{{link.text}}</nuxt-link></li>
        </ol>
        <div v-if="data.link_format == 'arrow'">
            <nuxt-link :to="link.href" v-for="link in data.links">{{link.text}} <span class="icon-arrow"></span></nuxt-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
