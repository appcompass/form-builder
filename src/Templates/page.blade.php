<template lang="pug">
@foreach($sections as $section)
  {!! str_pad('', $section['depth']) !!}{!! $section['value'] !!}
@endforeach
</template>

<script>
@foreach($imports as $import)
  import {!! $import !!} from '~components/{!! $import !!}'
@endforeach

  import common from '~/common'

  export default {
@if(!empty($layout))
    layout: '{!! $layout !!}',
@endif
    components: { {!! implode(',', $imports) !!} },
    data () {
      return {
        menus: {},
        site_meta: {},
        current_url: '',
        content: []
      }
    },
    asyncData (context) {
      return common.getPageData(context)
    },
    head() {
      return {
        title: this.page.title ? this.page.title : '',
        meta: this.page.head_meta ? this.page.head_meta : []
      }
    }

  }
</script>