<template lang="jade">
div
  div
    ThickPageBanner
    BreadCrumbRightSideLink
    ProcessTimeline
    MaintenanceDetails
</template>

<script>
  import ThickPageBanner from '~components/ThickPageBanner'
  import BreadCrumbRightSideLink from '~components/BreadCrumbRightSideLink'
  import ProcessTimeline from '~components/ProcessTimeline'
  import MaintenanceDetails from '~components/MaintenanceDetails'

  export default { components: { ThickPageBanner, BreadCrumbRightSideLink, ProcessTimeline, MaintenanceDetails } }
</script>

