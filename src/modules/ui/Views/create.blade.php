<section class="panel">
    <header class="panel-heading">
        {{ $meta->create->heading || '' }}
    </header>
    <div class="panel-body row">
        @if (!empty($meta->create->description_title))
            <div class="col-lg-12">
                <h4>{{ $meta->create->description_title }}</h4>
                @if(!empty($meta->create->description_text)) <p>{{ $meta->create->description_text }}</p> @endif
                <br>
            </div>
        @endif
        <div class="col-lg-12">

            {!! Form::open([
                'url' => $meta->base_url,
                'method' => 'POST',
                'data-target' => $meta->data_target,
                'class' => 'form-horizontal bucket-form ajax-form'])
            !!}

                @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

            {!! Form::close() !!}

            {{ var_dump($meta) }}
        </div>
    </div>
</section>