<section class="panel">

    <header class="panel-heading">
        {{ $meta->edit->heading }}
    </header>

    <div class="panel-body">
        {!!
            Form::model($record, [
                'class' => 'form-horizontal bucket-form ajax-form',
                'method' => 'put',
                'data-target' => '#record-detail',
                'url' => $meta->base_url
            ])
        !!}

            @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

        {!! Form::close() !!}
    </div>
</section>