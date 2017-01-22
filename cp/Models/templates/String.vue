<div>
    <input type="text" class="input" @input="$emit('input', {value: $event.target.value, pointer: pointer})" :value="data">
</div>