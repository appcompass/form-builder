@foreach($components as $component)
import {!! $component !!}Comp from '~components/{!! $component !!}'
export var {!! $component !!} = {!! $component !!}Comp

@endforeach