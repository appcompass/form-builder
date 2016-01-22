{!!
    Form::model($record, [
        'class' => 'form-horizontal bucket-form ajax-form',
        'method' => 'PUT',
        'data-target' => '#record-detail',
        'url' => $meta->base_url
    ])
!!}

    <section class="panel">
        <header class="panel-heading">
            {{ $meta->edit->heading or '' }}
        </header>
        <div class="panel-body row">
            @if (!empty($meta->edit->description_title) || !empty($meta->edit->description_text))
                <div class="col-lg-12">
                    @if(!empty($meta->edit->description_title )) <h4>{{ $meta->edit->description_title }}</h4> @endif
                    @if(!empty($meta->edit->description_text)) <p>{{ $meta->edit->description_text }}</p> @endif
                    <br>
                </div>
            @endif
            <div class="col-lg-12">
                @if(empty($meta->edit->dissallow_create_new))
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="btn-group">
                                <a id="editable-sample_new" class="btn btn-primary" href="#{{ substr($meta->base_url, 0, strrpos($meta->base_url, '/')) }}/create">
                                    Add New <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

            </div>
        </div>
    </section>
{!! Form::close() !!}
