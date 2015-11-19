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

                        @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

                    {!! Form::close() !!}

                    {{ var_dump($meta) }}

                </div>
            </section>