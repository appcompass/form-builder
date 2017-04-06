@foreach($components as $component => $path)
import {!! $component !!}Comp from '{!! $path !!}'
export var {!! $component !!} = {!! $component !!}Comp

@endforeach