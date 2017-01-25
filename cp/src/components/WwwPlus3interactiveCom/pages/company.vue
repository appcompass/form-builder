<template lang="pug">
div
  div
    ThickPageBanner
    MeetOurTeam
    SocialStream
</template>

<script>
  import ThickPageBanner from '~components/ThickPageBanner'
  import MeetOurTeam from '~components/MeetOurTeam'
  import SocialStream from '~components/SocialStream'

  export default {layout: 'public',components: {ThickPageBanner, MeetOurTeam, SocialStream}}
</script>

