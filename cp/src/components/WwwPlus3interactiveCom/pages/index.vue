<template lang="jade">
div
  div.col-12
    SliderBanner
  div.col-12
    SectionHeading
    div.col-6
      BoxCallouts
    div.col-6
      BoxCallouts
  div.col-12
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

  export default { components: { SliderBanner, SectionHeading, BoxCallouts, OurProcess, MeetOurTeam, SocialStream, CustomerTestimonials } }
</script>

