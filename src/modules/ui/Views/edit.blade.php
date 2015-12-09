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

                @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

            {!! Form::close() !!}
        </div>
    </div>
</section>