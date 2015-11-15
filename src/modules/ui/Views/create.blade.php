            <section class="panel">
                <header class="panel-heading">
                    {{ $meta->create->heading }}
                </header>
                <div class="panel-body">

                    {!! Form::open([
                        'url' => $meta->base_url,
                        'method' => 'POST',
                        'data-target' => $meta->data_target,
                        'class' => 'form-horizontal bucket-form ajax-form'])
                    !!}

                        @foreach($meta->form->fields as $fieldData)
                        <div class="form-group">
                            {!! Form::label($fieldData->name, $fieldData->label, ['class' => 'col-sm-3 control-label']) !!}
                            <div class="col-sm-6">
                                @if($fieldData->type == 'text')
                                    {!! Form::text($fieldData->name, null, ['class' => 'form-control', 'placeholder' => $fieldData->placeholder]) !!}
                                @elseif($fieldData->type == 'checkbox')
                                    {!! Form::checkbox($fieldData->name, 'true') !!}
                                @elseif($fieldData->type == 'textarea')
                                    {!! Form::textarea($fieldData->name, null, ['class' => 'form-control', 'placeholder' => $fieldData->placeholder]) !!}
                                @elseif($fieldData->type == 'selectlist')
                                    {!! Form::select($fieldData->name, $fieldData->data, null, ['class' => 'form-control', 'placeholder' => $fieldData->placeholder]) !!}
                                @elseif($fieldData->type == 'model_selectlist')
                                    {!! Form::select($fieldData->name, with(new $fieldData->data)->lists('name', 'id'), null, ['class' => 'form-control', 'placeholder' => $fieldData->placeholder]) !!}
                                @elseif($fieldData->type == 'layout_selector')
                                    <a href="">
                                        <div style="width: 3rem; height: 3rem; display: inline-block; background: orange; border: 1px solid #000;"><div style="display: block; float: left; width: 100%; height: 100%; background: #222;"></div></div>
                                    </a>
                                    <a href="">
                                        <div style="width: 3rem; height: 3rem; display: inline-block; background: orange; border: 1px solid #000;"><div style="display: block; float: left; width: 33.3%; height: 100%; background: #222;"></div></div>
                                    </a>
                                    <a href="">
                                        <div style="width: 3rem; height: 3rem; display: inline-block; background: orange; border: 1px solid #000;"><div style="display: block; float: right; width: 33.3%; height: 100%; background: #222;"></div></div>
                                    </a> <br>
                                    {!! Form::select($fieldData->name, $meta->available_layouts) !!}
                                @endif
                            </div>
                        </div>
                        @endforeach

                        {!! Form::submit('Save', ["class" => "btn btn-info"]) !!}

                    {!! Form::close() !!}

                    {{ var_dump($meta) }}

                </div>
            </section>