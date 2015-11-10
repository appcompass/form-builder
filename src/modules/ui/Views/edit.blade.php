<section class="panel">

    <header class="panel-heading">
        {{ $meta->edit->heading }}
    </header>

    <div class="panel-body">
        {!! Form::model($record, [
            'class' => 'form-horizontal bucket-form ajax-form',
            'method' => 'put',
            'data-target' => '#record-detail',
            'route' => [$meta->edit->route, $record->id]])
        !!}

            @foreach($meta->form->fields as $field)
            <div class="form-group">
                {!! Form::label($field->name, $field->label, ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-6">
                    @if($field->type == 'text')
                        {!! Form::text($field->name, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
                    @elseif($field->type == 'checkbox')
                        {!! Form::checkbox($field->name, true, ['class' => 'form-control']) !!}
                    @elseif($field->type == 'textarea')
                        {!! Form::textarea($field->name, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
                    @endif
                </div>
            </div>
            @endforeach

            <button type="submit" class="btn btn-info">Save</button>
        {!! Form::close() !!}
    </div>
</section>