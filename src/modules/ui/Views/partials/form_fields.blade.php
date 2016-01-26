@foreach($fields as $field)
    @if($field->type == 'fieldset_break')
            </div>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading">
            {{ $field->window_title or '' }}
        </header>
        <div class="panel-body row">
            @if(!empty($field->window_header) || !empty($field->window_sub_header))
            <div class="col-lg-12">
                 @if(!empty($field->window_header)) <h4>{{ $field->window_header }}</h4> @endif
                @if(!empty($field->window_sub_header)) <p>{{ $field->window_sub_header }}</p> @endif
                <br>
            </div>
            @endif
            <div class="col-lg-12">
    @else
        <div class="form-group @if($field->type == 'repeatable') form-repeatable @endif">
            {!! Form::label(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $field->label, ['class' => empty($repeatable) ? 'col-lg-3 control-label' : '']) !!}
            @if(empty($repeatable)) <div class="col-lg-6"> @endif
                @if($field->type == 'text')
                    {!! Form::text(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
                @elseif($field->type == 'slugify')
                    {!! Form::text(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, ['class' => 'form-control slugify' ,'data-source' => $field->field, 'placeholder' => $field->placeholder]) !!}
                @elseif($field->type == 'password')
                    {!! Form::password(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
                @elseif($field->type == 'textarea')
                    {!! Form::textarea(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, ['class' => 'form-control', 'rows' => '6', 'placeholder' => $field->placeholder]) !!}
                @elseif($field->type == 'wysiwyg')
                    {!! Form::textarea(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, ['class' => 'wysihtml5 form-control', 'rows' => '9', 'placeholder' => $field->placeholder]) !!}
                @elseif($field->type == 'selectlist')
                    {!! Form::select(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $field->data, null, ['class' => 'form-control']) !!}
                @elseif($field->type == 'checkbox')
                    @if(!empty($field->data))
                        <div class="checkbox">
                            @foreach($field->data as $checkbox)
                                <div class="col-lg-3">
                                    <label>
                                        {!! Form::checkbox($checkbox->name, 'true', null, ['class' => '']) !!}
                                        {{ $checkbox->label }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, 'true', null, ['class' => '']) !!}
                            </label>
                        </div>
                    @endif
                @elseif($field->type == 'radio')
                        @foreach($field->data as $label => $value)
                        <div class="radio">
                            <label>
                                {!! Form::radio(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $value, ['class' => 'form-control']) !!}
                               {{ $label }}
                            </label>
                        </div>
                        @endforeach
                @elseif($field->type == 'file')
                    {!! Form::file(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
                    <button class="btn btn-sm pull-right btn-primary open-select-image-modal">Select Image</button>
                    @if(isset($prefix) AND isset($index) AND isset($record->{$prefix}[$index]->{$field->name}))
                        <b>Image Path: {{ $record->{$prefix}[$index]->{$field->name} }}</b>
                    @elseif (!empty($record->{$field->name}))
                        <b>Image Path: {{ $record->{$field->name} }}</b>
                    @endif
                @elseif($field->type == 'datepicker')
                    {!! Form::date('name', null, ['class' => 'form-control form-control-inline input-medium date-picker-default', 'placeholder' => $field->placeholder]) !!}
                @elseif($field->type == 'from_to_input')
                    <div class="input-group input-large">
                        @foreach($field->data as $i => $from_to)
                            @if($i == 1) <span class="input-group-addon">{{ $field->operator }}</span> @endif
                            @if($field->type == 'text')
                                {!! Form::text($from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                            @elseif($from_to->type == 'password')
                                {!! Form::password($from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                            @elseif($from_to->type == 'datepicker')
                                {!! Form::date($from_to->name, null, ['class' => 'form-control date-picker-default', 'placeholder' => $from_to->placeholder]) !!}
                            @endif
                        @endforeach
                    </div>
                @elseif($field->type == 'from_to_list')
                    <div class="row">
                        @foreach($field->data as $i => $from_to)
                            @if($from_to->type == 'selectlist')
                                <div class="col-lg-6">
                                    {!! Form::select($from_to->name, $from_to->data, null, ['class' => 'form-control']) !!}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @elseif($field->type == 'from_to_mixed')
                    <div class="row">
                        @foreach($field->data as $i => $from_to)
                            @if($from_to->type == 'selectlist')
                                <div class="col-lg-6">
                                    {!! Form::select($from_to->name, $from_to->data, null, ['class' => 'form-control']) !!}
                                </div>
                            @elseif($field->type == 'text')
                                <div class="col-lg-6">
                                    {!! Form::text($from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                                </div>
                            @elseif($from_to->type == 'password')
                                <div class="col-lg-6">
                                    {!! Form::password($from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                                </div>
                            @elseif($from_to->type == 'datepicker')
                                <div class="col-lg-6">
                                    {!! Form::date($from_to->name, null, ['class' => 'form-control date-picker-default', 'placeholder' => $from_to->placeholder]) !!}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @elseif($field->type == 'model_selectlist')
                    {!! Form::select(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, with(new $field->data)->lists($field->key, $field->value), null, ['class' => 'form-control', 'placeholder' => isset($field->placeholder) ? $field->placeholder : null]) !!}
                @elseif($field->type == 'model_checkbox')
                    <div class="checkbox">
                        @foreach(with(new $field->data)->lists($field->key, $field->value) as $check_id => $check_label)
                            <div class="col-lg-3">
                                <label>
                                    {!! Form::checkbox($field->name.'[]', $check_id, !empty($record->{$field->name}) &&  in_array($check_id, $record->{$field->name}) ? true : null, ['class' => '']) !!}
                                    {{ $check_label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @elseif($field->type == 'filtered_selectlist')
                    {!! Form::select(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $meta->{$field->data}, null, ['class' => 'form-control', 'placeholder' => isset($field->placeholder) ? $field->placeholder : null]) !!}
                @elseif($field->type == 'filtered_checkbox')
                    <div class="checkbox">
                        @foreach($meta->{$field->data} as $check_id => $check_label)
                            <div class="col-lg-3">
                                <label>
                                    {!! Form::checkbox($field->name.'[]', $check_id, !empty($record->{$field->name}) &&  in_array($check_id, $record->{$field->name}) ? true : null, ['class' => '']) !!}
                                    {{ $check_label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @elseif($field->type == 'layout_selector')
                    {!! Form::select(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $meta->available_layouts) !!}
                @elseif($field->type == 'repeatable')
                    @if(isset($record))
                        @include('ui::partials.repeatable_block', ['prefix' => $field->name, 'records' => !empty($record->{$field->name}) ? $record->{$field->name}: [[]]])
                    @else
                        @include('ui::partials.repeatable_block', ['prefix' => $field->name, 'records' => [[]]])
                    @endif
                @endif
                @if ($field->help_block)
                    <small class="help-block">{{ $field->help_block }}</small>
                @endif
            @if(empty($repeatable)) </div> @endif

        </div>

    @endif
@endforeach

@if (isset($website))
<div class="modal fade" id="modal-photo-selector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span>Select an image</span></h4>
            </div>
            <div class="modal-body message">
                <ul class="image-selector" style="float: left; margin-top: 20px; width: 100%">
                    @foreach ($website->gallery->photos as $photo)
                    <li data-id="{{ $photo->id }}"><img src="https://placehold.it/200x200" alt="" title="{{ $photo->path }}" style="float: left; margin: 10px;"></li><?php //<img src="{{ $photo->path }}" alt=""></li> ?>
                    @endforeach
                </ul>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
@endif

@if(empty($repeatable))
{!! Form::submit('Save', ["class" => "btn btn-info"]) !!}

<script>
    (function photoSelector(w) {

        $('.open-select-image-modal').on('click', function(e) { e.preventDefault(), photoSelector.openModal($(this)) });
        $('.image-selector > li').on('click', function() { photoSelector.selectImage($(this).attr('data-id')) } )

        var photoSelector = {
            selectedImage: undefined,
            relatedFormInput: undefined,
            form: undefined,
            modal: $('#modal-photo-selector'),
            hidden: $('<input>').attr({
                type: 'hidden',
                name: 'selected_file',
                value: undefined
            }),
            openModal: function(ele) {
                this.relatedFormInput = ele.siblings('input[type="file"]');
                this.form = ele.parents('form')[0];
                this.modal.modal()
            },
            selectImage: function(id) {
                this.hidden.val(id).appendTo(this.form);
                this.relatedFormInput.val(''); // reset input value, for good measure
                this.modal.modal('hide');
            }
        }


    })(window)

</script>

<script>
    function slugify(text) {
      return text.toString().toLowerCase()
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-')         // Replace multiple - with single -
        .replace(/^-+/, '')             // Trim - from start of text
        .replace(/-+$/, '');            // Trim - from end of text
    }

    function incrementAttrArray(overide){
        return function(i, v){
            return v.replace(/\[(\d+)\]/, function(match, num){
                return '[' + (typeof overide !== 'undefined' ? overide : + num + 1) + ']';
            });
        }
    }

    function reIndexRepeatables(elms){
        elms.each(function(i,v){
            fixPosition($(this), i);
        });
    }

    function fixPosition(elm, overide) {
        elm.find('.repeatable-number')
            .text(function(i,v){
                return typeof overide !== 'undefined' ? overide+1 : parseInt(v,10)+1;
            });

        elm.find('[name]')
            .attr('id', incrementAttrArray(overide))
            .attr('name', incrementAttrArray(overide));

        elm.find('[for]')
            .attr('for', incrementAttrArray(overide));
    }

    $(document).ready(function(){
        $('.wysihtml5').wysihtml5({
            "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
            "emphasis": true, //Italics, bold, etc. Default true
            "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
            "html": false, //Button which allows you to edit the generated HTML. Default false
            "link": true, //Button to insert a link. Default true
            "image": true, //Button to insert an image. Default true,
            "color": false //Button to change color of font
        });

        // Slugify logic
        var name = '';
        $('.slugify').each(function(i,e){
            name = $(e).attr('data-source');
            $('input[name="'+name+'"').on('keyup', function(elm){
                $(e).val(slugify($(this).val()));
            })
        });

        // Repeatable block logic
        $('.form-repeatable-add').on('click', function(e){
            e.preventDefault();
            var container = $(this).parent().prev('.repeatable-container');
            var cloned = container.clone(true);

            cloned.find('input, textarea')
                .val('')
                .removeAttr('checked');

            fixPosition(cloned);


            // cloned.find('.repeatable-number')
            //     .text(function(i,v){
            //         return parseInt(v,10)+1;
            //     })

            // cloned.find('input, textarea')
            //     .val('')
            //     .removeAttr('checked');

            // cloned.find('[name]')
            //     .attr('id', incrementAttrArray)
            //     .attr('name', incrementAttrArray);

            // cloned.find('[for]')
            //     .attr('for', incrementAttrArray);

            // cloned.find('[name]').each(function(i){
            //     $(this).attr('name', increment_index($(this).attr('name')));
            // });

            cloned.insertAfter(container);
        });

        $('.panel-heading .fa-arrows').on('click', function(e){
            // draggable
        });

        $('.panel-heading .fa-times').on('click', function(e){
            $(this).parents('.repeatable-container').remove();
            reIndexRepeatables($('.repeatable-container'));
        });
    });
</script>
@endif

<?php
/*
The below is the example array of all possibilities.
[
    [
        'label' => 'Label',
        'name' => 'field_name',
        'placeholder' => 'Some Placeholder',
        'type' => 'text',
        'help_block' => '',
    ],[
        'label' => 'Page URL',
        'name' => 'slug',
        'placeholder' => '',
        'type' => 'slugify',
        'field' => 'title',
        'help_block' => 'This field is set automatically.',
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
        'name' => 'this_is_not_used',
        'type' => 'from_to_input',
        'operator' => 'to',
        'data' => [
            [
                'name' => 'from_name',
                'placeholder' => '',
                'type' => 'datepicker', // or text, or password
            ],[
                'name' => 'to_name',
                'placeholder' => '',
                'type' => 'datepicker', // or text, or password
            ]
        ],
        'help_block' => '',
    ],[
        'label' => 'From To lists',
        'type' => 'from_to_list',
        'name' => 'this_is_not_used',
        'data' => [
            [
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
        ],
        'help_block' => '',
    ],,[
        'label' => 'From To Mixed',
        'type' => 'from_to_mixed',
        'name' => 'this_is_not_used',
        'data' => [
            [
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
                'type' => 'datepicker', // or text, or password
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
        'help_block' => '',
    ]

] */
