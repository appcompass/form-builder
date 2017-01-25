<template lang="jade">
div
  div
    ThickPageBanner
    ProjectList
    section.section-module.section-clients
      SectionHeading
      div.row
        div.medium-9.medium-centered.columns
          div.row
            MoreClientsList
    WhiteBreakCalloutSectionLinks
    BlueBreakCallout
</template>

<script>
  import ThickPageBanner from '~components/ThickPageBanner'
  import ProjectList from '~components/ProjectList'
  import SectionHeading from '~components/SectionHeading'
  import MoreClientsList from '~components/MoreClientsList'
  import WhiteBreakCalloutSectionLinks from '~components/WhiteBreakCalloutSectionLinks'
  import BlueBreakCallout from '~components/BlueBreakCallout'

  export default {layout: 'public',components: {ThickPageBanner, ProjectList, SectionHeading, MoreClientsList, WhiteBreakCalloutSectionLinks, BlueBreakCallout}}
</script>

