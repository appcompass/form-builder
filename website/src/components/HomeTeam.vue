<template lang="jade">
section.section-module.section-team
  .row
    .medium-8.columns.medium-centered
      .secition-header
        h2.section-heading The Team
        .section-desc
          p Plus 3 Interactive is a customer-focused business. Our team finds the right solutions to our customers’ unique challenges.
          p
            router-link(to="/") Check out the people who make our company work
              span.icon-arrow
  .section-team-members
    a.section-team-member.imene(@click="$emit('open', {type: 'Imene', active: true})")
      span.team-hover
        span.team-name Imene Saidi
        span.team-position Information Architect

    a.section-team-member.jubair
      span.team-hover
        span.team-name Jubair Saidi
        span.team-position Information Architect

    a.section-team-member.aisha
      span.team-hover
        span.team-name Aisha Saidi
        span.team-position Information Architect

    a.section-team-member.lazarus
      span.team-hover
        span.team-name Lazarus Morrision
        span.team-position Developer

    a.section-team-member.random
      span.team-hover
        span.team-name A Random Dude
        span.team-position Developer

</template>

<script>
  import Imene from './Imene'

  export default {
    name: 'HomeTeam',
    components: { Imene }
  }
</script>

<style lang="sass" scoped>
.imene
  background-image: url('/static/assets/images/content/team_imene.jpg')
.jubair
  background-image: url('/static/assets/images/content/team_jubair.jpg')
.aisha
  background-image: url('/static/assets/images/content/team_aisha.jpg')
.lazarus
  background-image: url('/static/assets/images/content/team_lazarus.jpg')
.random
  background-image: url('/static/assets/images/content/team_random.jpg')
</style>
