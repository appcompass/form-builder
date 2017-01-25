<template lang="jade">
div
  div
    SliderBanner
  section.section-module.section-solutions
    SectionHeading
    div.row
      div.medium-6.columns
        div.row
          BoxCallouts
      div.medium-6.columns
        div.row
          BoxCallouts
  div
    OurProcess
    MeetOurTeam
    SocialStream
    CustomerTestimonials
</template>

<script>
  import SliderBanner from '~components/SliderBanner'
  import SectionHeading from '~components/SectionHeading'
  import BoxCallouts from '~components/BoxCallouts'
  import OurProcess from '~components/OurProcess'
  import MeetOurTeam from '~components/MeetOurTeam'
  import SocialStream from '~components/SocialStream'
  import CustomerTestimonials from '~components/CustomerTestimonials'

  export default {layout: 'public',components: {SliderBanner, SectionHeading, BoxCallouts, OurProcess, MeetOurTeam, SocialStream, CustomerTestimonials}}
</script>

