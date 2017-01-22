<div @input="$emit('input', {value: $event.target.value, pointer: pointer})">
    Text {{ pointer }}
</div>
