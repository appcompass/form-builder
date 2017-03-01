{!! Form::open([
    'route' => $meta->create->route,
    'data-target' => $meta->data_target,
    'class' => 'form-horizontal bucket-form ajax-form'])
!!}
    <section class="panel">
        <header class="panel-heading">
            {{ $meta->create->heading or '' }}
        </header>
        <div class="panel-body row">
            @if (!empty($meta->create->description_title) || !empty($meta->create->description_text))
                <div class="col-lg-12">
                    @if(!empty($meta->create->description_title )) <h4>{{ $meta->create->description_title }}</h4> @endif
                    @if(!empty($meta->create->description_text)) <p>{{ $meta->create->description_text }}</p> @endif
                    <br>
                </div>
            @endif
            <div class="col-lg-12">

                @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

            </div>
        </div>
    </section>
{!! Form::close() !!}
