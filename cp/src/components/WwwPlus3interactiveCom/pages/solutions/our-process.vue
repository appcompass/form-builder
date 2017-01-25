<template lang="jade">
div
  div
    ThickPageBanner
    BreadCrumbRightSideLink
    div.row
      div.xsmall-12.columns
        ProcessTimeline
    MaintenanceDetails
</template>

<script>
  import ThickPageBanner from '~components/ThickPageBanner'
  import BreadCrumbRightSideLink from '~components/BreadCrumbRightSideLink'
  import ProcessTimeline from '~components/ProcessTimeline'
  import MaintenanceDetails from '~components/MaintenanceDetails'

  export default {layout: 'public',components: {ThickPageBanner, BreadCrumbRightSideLink, ProcessTimeline, MaintenanceDetails}}
</script>

