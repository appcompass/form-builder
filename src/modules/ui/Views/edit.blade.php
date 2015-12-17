<section class="panel">

    <header class="panel-heading">
        {{ $meta->edit->heading or '' }}
    </header>
    <div class="panel-body row">
        @if (!empty($meta->create->description_title))
            <div class="col-lg-12">
                <h4>{{ $meta->create->description_title or '' }}</h4>
                @if(!empty($meta->create->description_text)) <p>{{ $meta->create->description_text }}</p> @endif
                <br>
            </div>
        @endif
        <div class="col-lg-12">
            {!!
                Form::model($record, [
                    'class' => 'form-horizontal bucket-form ajax-form',
                    'method' => 'PUT',
                    'data-target' => '#record-detail',
                    'url' => $meta->base_url
                ])
            !!}
                <div class="form-group">
                    <div class="col-lg-12">
                        <div class="btn-group">
                            <a id="editable-sample_new" class="btn btn-primary" href="#{{ substr($meta->base_url, 0, strrpos($meta->base_url, '/')) }}/create">
                                Add New <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

            {!! Form::close() !!}
        </div>
    </div>
</section>