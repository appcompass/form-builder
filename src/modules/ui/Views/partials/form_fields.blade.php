@foreach($fields as $field)
@if(!isset($field->config->allowed_methods) || (isset($field->config->allowed_methods) && in_array($meta->method_name,$field->config->allowed_methods)))
    @if($field->type == 'fieldset_break')
            </div>
        </div>
    </section>
    <section class="panel">
        <header class="panel-heading">
            {{ $field->label or '' }}
        </header>
        <div class="panel-body row">
            @if(!empty($field->config->window_header) || !empty($field->config->window_sub_header))
            <div class="col-lg-12">
                 @if(!empty($field->config->window_header)) <h4>{{ $field->config->window_header }}</h4> @endif
                @if(!empty($field->config->window_sub_header)) <p>{{ $field->config->window_sub_header }}</p> @endif
                <br>
            </div>
            @endif
            <div class="col-lg-12">
    @else
        <div class="form-group @if($field->type == 'repeatable') form-repeatable @endif">
            {!! Form::label(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $field->label, ['class' => empty($repeatable) ? 'col-lg-3 control-label' : '']) !!}
            @if(empty($repeatable)) <div class="col-lg-6"> @endif
                @if($field->type == 'text')
                    {!! Form::text(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, array_merge(['class' => 'form-control', 'placeholder' => $field->placeholder], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
                @elseif($field->type == 'slugify')
                    {!! Form::text(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, array_merge(['class' => 'form-control slugify' ,'data-source' => $field->field, 'placeholder' => $field->placeholder], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
                @elseif($field->type == 'password')
                    <div class="password">
                        {!! Form::password(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, array_merge(['class' => 'form-control', 'placeholder' => $field->placeholder], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
                    </div>
                @elseif($field->type == 'textarea')
                    {!! Form::textarea(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, array_merge(['class' => 'form-control', 'rows' => '6', 'placeholder' => $field->placeholder], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
                @elseif($field->type == 'wysiwyg')
                    {!! Form::textarea(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, array_merge(['class' => 'wysihtml5 form-control', 'rows' => '9', 'placeholder' => $field->placeholder], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
                @elseif($field->type == 'selectlist')
                    {!! Form::select(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $field->data, null, array_merge(['class' => 'form-control'], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
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
                                {!! Form::checkbox(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, 'true', null, array_merge(['class' => ''], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
                            </label>
                        </div>
                    @endif
                @elseif($field->type == 'radio')
                        @foreach($field->data as $label => $value)
                        <div class="radio">
                            <label>
                                {!! Form::radio(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, $value, array_merge(['class' => 'form-control'], !empty($field->attributes) ? (array) $field->attributes : [])) !!}
                               {{ $label }}
                            </label>
                        </div>
                        @endforeach
                @elseif($field->type == 'file')
                    @if(isset($website) && $website->gallery)
                        <div class="row">
                            <div class="col-lg-8">
                    @endif
                    {!! Form::file(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, ['class' => 'form-control', 'placeholder' => $field->placeholder]) !!}
                    @if(isset($website) && $website->gallery)
                            </div>
                    @endif
                     @if(isset($website) && $website->gallery)
                            <div class="col-lg-4">
                                <button class="btn btn-sm pull-right btn-primary open-select-image-modal">Or Select Image</button>
                            </div>
                        </div>
                    @endif
                    @if(isset($prefix) AND isset($index) AND isset($record->{$prefix}[$index]->{$field->name}))
                        <b class="image-path"><img src="{{ $record->{$prefix}[$index]->{$field->name} }}" height="180" alt="" style="max-width: 250px"></b>
                    @elseif (!empty($record->{$field->name}))
                        <b class="image-path"><img src="{{ $record->{$field->name} }}" height="180" alt="" style="max-width: 250px"></b>
                    @endif
                @elseif($field->type == 'datepicker')
                    {!! Form::date(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$field->name}]" : $field->name, null, ['class' => 'form-control form-control-inline input-medium date-picker-default', 'placeholder' => $field->placeholder]) !!}
                @elseif($field->type == 'from_to_input')
                    <div class="input-group input-large">
                        @foreach($field->data as $i => $from_to)
                            {!! Form::label(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, !empty($from_to->label) ? $from_to->label : null, []) !!}
                            @if($i == 1) <span class="input-group-addon">{{ $field->operator }}</span> @endif
                            @if($field->type == 'text')
                                {!! Form::text(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                            @elseif($from_to->type == 'password')
                                {!! Form::password(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                            @elseif($from_to->type == 'datepicker')
                                {!! Form::date(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, null, ['class' => 'form-control date-picker-default', 'placeholder' => $from_to->placeholder]) !!}
                            @endif
                        @endforeach
                    </div>
                @elseif($field->type == 'from_to_list')
                    <div class="row">
                        @foreach($field->data as $i => $from_to)
                            @if($from_to->type == 'selectlist')
                                <div class="col-lg-6">
                                    {!! Form::label(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, !empty($from_to->label) ? $from_to->label : null, []) !!}
                                    {!! Form::select(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, $from_to->data, null, ['class' => 'form-control']) !!}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @elseif($field->type == 'from_to_mixed')
                    <div class="row">
                        @foreach($field->data as $i => $from_to)
                            <div class="col-lg-6">
                            {!! Form::label(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, !empty($from_to->label) ? $from_to->label : null, []) !!}
                            @if($from_to->type == 'selectlist')
                                    {!! Form::select(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, $from_to->data, null, ['class' => 'form-control']) !!}
                            @elseif($from_to->type == 'text')
                                    {!! Form::text(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                            @elseif($from_to->type == 'password')
                                    {!! Form::password(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, null, ['class' => 'form-control', 'placeholder' => $from_to->placeholder]) !!}
                            @elseif($from_to->type == 'datepicker')
                                    {!! Form::date(isset($prefix) && isset($repeatable) && isset($index) ? "{$prefix}[{$index}][{$from_to->name}]" : $from_to->name, null, ['class' => 'form-control date-picker-default', 'placeholder' => $from_to->placeholder]) !!}
                            @endif
                            </div>
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
                @elseif($field->type == 'multi_select')
                    <select class="multi_select form-control" name="{{ $field->name }}[]" multiple>
                        <optgroup label="Admin Permissions">
                            <option value="create-users" @if(isset($record) && in_array('create-users', $record->{$field->name})) selected @endif>Create Users</option>
                            <option value="cp-login" @if(isset($record) && in_array('cp-login', $record->{$field->name})) selected @endif>CP Login</option>
                            <option value="create-galleries" @if(isset($record) && in_array('create-galleries', $record->{$field->name})) selected @endif>Create Galleries</option>
                        </optgroup>
                    </select>
                @endif
                @if ($field->help_block)
                    <small class="help-block">{{ $field->help_block }}</small>
                @endif
            @if(empty($repeatable)) </div> @endif

        </div>

    @endif
@endif
@endforeach

@if(isset($website) && $website->gallery)
<div class="modal fade" id="modal-photo-selector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><span>Select an image</span></h4>
            </div>
            <div class="modal-body message media-gal isotope">
                <ul class="image-selector " style="float: left; margin-top: 20px; width: 100%">
                    @if(isset($website) && $website->gallery->photos->count())
                        @include('photos::photo-grid', ['photos' => $website->gallery->photos, 'is_modal' => true])
                    @else
                        <h4 class="align-center page-header">There are no images in this gallery yet.</h4>
                    @endif
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
{!! Form::submit('Save', ["class" => "btn btn-primary"]) !!}

<script>
    (function mediaSelector(w) {

        $('.open-select-image-modal').on('click', function(e) { e.preventDefault(), mediaSelector.openModal($(this)) });
        $('.image-selector > div').on('click', function() { mediaSelector.selectImage($(this)) } )

        var mediaSelector = {
            selectedImage: undefined,
            relatedFormInput: undefined,
            pathLabels: [],
            form: undefined,
            modal: $('#modal-photo-selector'),
            hidden: $('<input name="selected_files[]">').attr({
                type: 'hidden',
                value: undefined
            }),
            openModal: function(ele) {
                this.relatedFormInput = ele.siblings('input[type="file"]');
                this.pathLabels = ele.siblings('b.image-path');

                this.form = ele.parents('form')[0];
                this.modal.modal()
            },
            selectImage: function(item) {
                var id = item.attr('data-id'),
                    path = item.attr('data-path');

                this.pathLabels.each(function(idx, label) {
                    $(label).html('<b>Image Path: <b>' + path)
                    $(label).html('<img src="' + path +'" height="180">')
                })
                $('<input type="hidden" name="_selected_'+this.relatedFormInput.attr('name')+'">').val(id).appendTo(this.form);
                // this.hidden.val(id).appendTo(this.form);
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

        $('.multi_select').select2({
            // data: '' FETCH DATA USING VUE
        });
    });
</script>

<script>

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
    ],[
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
