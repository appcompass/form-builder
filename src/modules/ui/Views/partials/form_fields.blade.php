@foreach($fields as $field)
<div class="form-group">
    {!! Form::label($field->name, $field->label, ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        @if($field->type == 'text')
            {!! Form::text($field->name, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'password')
            {!! Form::password($field->name, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'checkbox')
            {!! Form::checkbox($field->name, 'true', ['class' => 'form-control']) !!}
        @elseif($field->type == 'textarea')
            {!! Form::textarea($field->name, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'selectlist')
            {!! Form::select($field->name, $field->data, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'model_selectlist')
            {!! Form::select($field->name, with(new $field->data)->lists('name', 'id'), null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'layout_selector')
            {!! Form::select($field->name, $meta->available_layouts) !!}
        @endif
        @if ($field->help_block)
            <span class="help-block">{{ $field->help_block }}</em></span>
        @endif
    </div>
</div>
@endforeach

{!! Form::submit('Save', ["class" => "btn btn-info"]) !!}
