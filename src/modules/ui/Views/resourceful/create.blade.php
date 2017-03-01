{!! Form::open([
    'url' => $meta->base_url,
    'data-target' => '#record-detail',
    'class' => 'form-horizontal bucket-form ajax-form'])
!!}
    <section class="panel">
        <header class="panel-heading">
            {{ $meta->heading or '' }}
        </header>
        <div class="panel-body row">
            @if (!empty($meta->description_title) || !empty($meta->description_text))
                <div class="col-lg-12">
                    @if(!empty($meta->description_title )) <h4>{{ $meta->description_title }}</h4> @endif
                    @if(!empty($meta->description_text)) <p>{{ $meta->description_text }}</p> @endif
                    <br>
                </div>
            @endif
            <div class="col-lg-12">

                @include('ui::partials.form_fields', ['fields' => $meta->form->fields])

            </div>
        </div>
    </section>
{!! Form::close() !!}
