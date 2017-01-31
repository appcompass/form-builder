<template lang="pug">
@foreach($sections as $section)
  {!! str_pad('', $section['depth']) !!}{!! $section['value'] !!}
@endforeach
</template>

<script>
  import * as Components from '~components'
  import common from '~/common'

  export default {
@if(!empty($layout))
    layout: '{!! $layout !!}',
@endif
    components: Components,
    data (context) {
      return common.getPageData(context)
    },
    head() {
      return {
        title: this.page.title ? this.page.title : '',
        meta: this.page.head_meta ? this.page.head_meta : [],
      }
    }

  }
</script>