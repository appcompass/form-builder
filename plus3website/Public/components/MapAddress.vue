<template lang="pug">
  .section-contact(v-if='data')
    .contact-map
      iframe(src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2948.3207106995806!2d-71.05980768454381!3d42.357003979187034!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e37084760558db%3A0x206840278228b95b!2s50+Milk+St%2C+Boston%2C+MA+02109!5e0!3m2!1sen!2sus!4v1466794543251', width='600', height='450', frameborder='0', style='border:0', allowfullscreen='')
    .contact-info
      .contact-info-content
        h2.contact-info-heading Get In Touch
        p 50 Milk St.
          br
          | 16th Floor
          br
          | Boston, MA 02109
        p +1 (857) 600-2703
</template>

<script>
  export default {
    props: ['data'],
    mounted () {
    }
  }
</script>
