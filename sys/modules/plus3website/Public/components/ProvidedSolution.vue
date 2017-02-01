<template>
  <div v-if="data">
    <section class="section-solution" v-for="row in data.solutions">
      <div class="row">
        <div class="medium-6 columns medium-text-center" :class=" row.layout == 'left' ? 'medium-push-6' : ''">
          <p class="solution-graphic"><img :src="row.solution_photo" :width="row.photo_width" :height="row.photo_height"></p>
        </div>
        <div class="medium-6 columns" :class=" row.layout == 'left' ? 'medium-pull-6' : ''">
          <h2>{{row.title}}</h2>
          <div v-html="row.description"></div>
          <ul class="blue-list">
            <li v-for="project in row.projects_using_solution"><nuxt-link :to="project.href">{{project.text}}</nuxt-link></li>
          </ul>
          <hr>
          <h3>{{row.link_description}}</h3>
          <p><nuxt-link :to="row.link_href" class="btn-blue">{{row.link_title}} <span class="icon-arrow"></span></nuxt-link></p>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
