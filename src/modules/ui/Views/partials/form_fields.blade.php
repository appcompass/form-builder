@foreach($fields as $field)
<div class="form-group">
    {!! Form::label($field->name, $field->label, ['class' => 'col-sm-3 control-label']) !!}
    <div class="col-sm-6">
        @if($field->type == 'text')
            {!! Form::text($field->name, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'password')
            {!! Form::password($field->name, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'textarea')
            {!! Form::textarea($field->name, null, ['class' => 'form-control', 'rows' => '6', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'selectlist')
            {!! Form::select($field->name, $field->data, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'checkbox')
            @if(!empty($field->data))
                @foreach($field->data as $label => $name)
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox($field->name[$name], 'true', ['class' => 'form-control']) !!}
                       {{ $label }}
                    </label>
                </div>
                @endforeach
            @else
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox($field->name, 'true', ['class' => 'form-control']) !!}
                    </label>
                </div>
            @endif
        @elseif($field->type == 'radio')
                @foreach($field->data as $label => $value)
                <div class="radio">
                    <label>
                        {!! Form::radio($field->name, $value, ['class' => 'form-control']) !!}
                       {{ $label }}
                    </label>
                </div>
                @endforeach
        @elseif($field->type == 'file')
            {!! Form::file($field->name, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'datepicker')
            {!! Form::text($field->name, ['class' => 'form-control form-control-inline input-medium date-picker-default', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'from_to_input')
            <div class="input-group input-large">
                @foreach($field->data as $i => $from_to)
                    @if($i == 1) <span class="input-group-addon">{{ $field->operator }}</span> @endif
                    @if($field->type == 'text')
                        {!! Form::text($from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                    @elseif($from_to->type == 'password')
                        {!! Form::password($from_to->name, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                    @elseif($from_to->type == 'datepicker')
                        {!! Form::text($from_to->name, ['class' => 'form-control date-picker-default', 'placeholder' => $from_to->placeholder]) !!}
                    @endif
                @endforeach
            </div>
        @elseif($field->type == 'from_to_list')
            <div class="row">
                @foreach($field->data as $i => $from_to)
                    @if($from_to->type == 'selectlist')
                        <div class="col-sm-6">
                            {!! Form::select($from_to->name, $from_to->data, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                        </div>
                    @endif
                @endforeach
            </div>
        @elseif($field->type == 'model_selectlist')
            {!! Form::select($field->name, with(new $field->data)->lists($field->label, $field->value), null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
        @elseif($field->type == 'layout_selector')
            {!! Form::select($field->name, $meta->available_layouts) !!}
        @endif
        @if ($field->help_block)
            <small class="help-block">{{ $field->help_block }}</small>
        @endif
    </div>
</div>
@endforeach

{!! Form::submit('Save', ["class" => "btn btn-info"]) !!}
{{--
The below is the example array of all possibilities.
[
    [
        'label' => 'Label',
        'name' => 'field_name',
        'placeholder' => 'Some Placeholder',
        'type' => 'text',
        'help_block' => '',
    ],[
        'label' => 'Password',
        'name' => 'password',
        'placeholder' => '',
        'type' => 'password',
        'help_block' => '',
    ],[
        'label' => 'Description',
        'name' => 'description',
        'placeholder' => 'Page Description Block',
        'type' => 'textarea',
        'help_block' => 'The title of the page.',
    ],[
        'label' => 'A Managed Website',
        'name' => 'config[managed]',
        'placeholder' => '',
        'type' => 'checkbox',
        'help_block' => '',
    ],[
        'label' => 'Check box with many options',
        'name' => 'config[managed]',
        'placeholder' => '',
        'type' => 'checkbox',
        'data' => [
            [
                'name' => 'sometimes', // turns into:  config['managed']['sometimes'] = true
                'label' => 'Sometimes',
            ],[
                'name' => 'always',
                'label' => 'Always',
            ]
        ],
        'help_block' => '',
    ],[
        'label' => 'Strict SSL Params',
        'name' => 'config[server][server_ssl][strict]',
        'placeholder' => '',
        'type' => 'radio',
        'data' => [
            'Yes' => 1,
            'No' => 0,
        ],
        'help_block' => '',
    ],[
        'label' => 'Layout Type',
        'name' => 'layout',
        'placeholder' => '',
        'type' => 'layout_selector',
        'help_block' => 'Select the page\'s layout.',
    ],[
        'label' => 'Status',
        'name' => 'status',
        'placeholder' => 'Choose a Status',
        'type' => 'selectlist',
        'data' => [
            'published' => 'Published',
            'draft' => 'Draft',
            'private' => 'Private',
        ],
        'help_block' => 'What is the status of this entry?',
    ],[
        'label' => 'Category',
        'name' => 'category',
        'placeholder' => 'Choose a Category',
        'type' => 'model_selectlist',
        'data' => BlogCategory::class,
        'label' => 'name',
        'value' => 'id',
        'help_block' => 'What is the status of this entry?',
    ],[
        'label' => 'Layout Type',
        'name' => 'layout',
        'placeholder' => '',
        'type' => 'layout_selector',
        'help_block' => 'Select the page\'s layout.',
    ],[
        'label' => 'File Upload',
        'name' => 'somefile',
        'placeholder' => '',
        'type' => 'file',
        'help_block' => '',
    ],[
        'label' => 'Date Picker',
        'name' => 'somedate',
        'placeholder' => '',
        'type' => 'datepicker',
        'help_block' => '',
    ],[
        'label' => 'From To Inputs',
        'type' => 'from_to_input',
        'operator' => 'to',
        'data' => [
            'name' => 'from_name',
            'placeholder' => '',
            'type' => 'datepicker', // or text, or password
        ],[
            'name' => 'to_name',
            'placeholder' => '',
            'type' => 'datepicker', // or text, or password
        ],
        'help_block' => '',
    ],[
        'label' => 'From To lists',
        'type' => 'from_to_list',
        'data' => [
            'name' => 'from_name',
            'placeholder' => '',
            'type' => 'selectlist',
            'data' => [
                'published' => 'Published',
                'draft' => 'Draft',
                'private' => 'Private',
            ],
        ],[
            'name' => 'to_name',
            'placeholder' => '',
            'type' => 'selectlist',
            'data' => [
                'published' => 'Published',
                'draft' => 'Draft',
                'private' => 'Private',
            ],
        ],
        'help_block' => '',
    ],[
        'label' => 'WYSIWYG Input Field',
        'name' => 'some_filed_name',
        'placeholder' => '',
        'type' => 'wysiwyg',
        'help_block' => 'Select the page\'s layout.',
    ],[
        'label' => 'Repeatable Input Fields',
        'name' => 'group_name_id',
        'type' => 'repeatable',
        'data' => [ // Same structure as the rest of this array.  below is example.
            [
                'label' => 'Description',
                'name' => 'description',
                'placeholder' => 'Page Description Block',
                'type' => 'textarea',
                'help_block' => 'The title of the page.',
            ],[
                'label' => 'A Managed Website',
                'name' => 'config[managed]',
                'placeholder' => '',
                'type' => 'checkbox',
                'help_block' => '',
            ]
        ],
    ]

] --}}