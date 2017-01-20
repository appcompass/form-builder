{
  template: "<textarea class=\"textarea\" @input=\"$emit('input', {value: $event.target.value, pointer: pointer})\"></textarea>",
  props: ['pointer', 'data']
}