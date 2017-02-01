<template>
  <div v-if="data" class="process-timeline">
    <div class="process-step-container" v-for="(step, i) in data.process_steps">
      <div class="process-step" :class="'process-step-'+(i+1)">
        <div class="process-step-top">
          <div class="process-step-line"></div>
          <div class="process-step-content">
            <img class="process-step-icon" :src="step.image" :width="step.image_width" :height="step.image_height">
            <h2 class="process-step-title">{{(i+1)}} <span>{{step.title}}</span></h2>
          </div>
        </div>
        <div class="process-step-bot">
          <div class="process-step-desc process-step-content" v-html="step.description"></div>
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
