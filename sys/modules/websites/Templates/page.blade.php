<template lang="pug">
@foreach($sections as $section)
  {!! str_pad('', $section['depth']) !!}{!! $section['value'] !!}
@endforeach
</template>

<script>
@foreach($imports as $import)
  import {!! $import !!} from '~components/{!! $import !!}'
@endforeach

  export default {
@if(!empty($layout))
    layout: '{!! $layout !!}',
@endif
    components: {
      {!! implode(",\n      ", $imports) !!}
    }

  }
</script>