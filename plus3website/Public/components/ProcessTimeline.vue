<template lang="pug">
  .process-timeline(v-if='data')
    .process-step-container(v-for='(step, i) in data.process_steps')
      .process-step(:class="'process-step-'+(i+1)")
        .process-step-top
          .process-step-line
          .process-step-content
            img.process-step-icon(:src='step.image', :width='step.image_width', :height='step.image_height')
            h2.process-step-title
              | {{(i+1)}}
              span {{step.title}}
        .process-step-bot
          .process-step-desc.process-step-content(v-html='step.description')
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
