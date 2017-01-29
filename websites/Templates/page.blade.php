<template lang="pug">
@foreach($sections as $section)
  {!! str_pad('', $section['depth']) !!}{!! $section['value'] !!}
@endforeach
</template>

<script>
  import axios from 'axios'
@foreach($imports as $import)
  import {!! $import !!} from '~components/{!! $import !!}'
@endforeach

  export default {
@if(!empty($layout))
    layout: '{!! $layout !!}',
@endif
    components: {
      {!! implode(",\n      ", $imports) !!}
    },
    data ({route, error}) {
      return axios.get(`http://api.p3in.com.dev/content${route.path}`)
      .then((res) => {
        res.data.current_url = route.path
        return res.data
      }).catch((e) => {
        return error({ statusCode: 404, message: e.message })
      })
    },
    head() {
      return {
        title: this.page.title ? this.page.title : '',
        meta: this.page.head_meta ? this.page.head_meta : [],
      }
    }

  }
</script>