        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <div class="col-sm-3">

                    <section class="panel">
                        <div class="panel-body">
                            <ul class="nav nav-pills nav-stacked mail-nav">
                                {{-- {{ dd($nav->items) }} --}}
                                <li class="active"><a href="#"> <i class="fa fa-list"></i> {{ $meta->create->heading }} </a></li>
                            </ul>
                        </div>
                    </section>
                </div>
                <div class="col-sm-9">
                    <section class="panel">
                        <header class="panel-heading">
                            {{ $meta->create->heading }}
                        </header>
                        <div class="panel-body">

                            {!! Form::open(['route' => $meta->create->route, 'method' => 'POST', 'data-target' => '#main-content', 'class' => 'form-horizontal bucket-form ajax-form']) !!}
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
                                        @endif
                                    </div>
                                </div>
                                @endforeach

                                {!! Form::submit('Save', ["class" => "btn btn-info"]) !!}

                            {!! Form::close() !!}

                            {{ dd($meta) }}

{{--                             <form class="form-horizontal bucket-form ajax-form" method="post" action="/cp/galleries" data-target="#main-content">
								{{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="title" placeholder="Gallery Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-6">
                                        <textarea class="form-control" name="description" placeholder="A discription of this gallery goes here"></textarea>
                                    </div>
                                </div> --}}

                    {{--                    <div class="form-group has-error">
                                    <label class="col-sm-3 control-label col-lg-3" for="inputError">Input with error</label>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" id="inputError">
                                    </div>
                                </div>
                    --}}
                                    {{-- <button type="submit" class="btn btn-info">Create</button> --}}
                                {{-- </form> --}}
                        </div>
                    </section>
                </div>
            </div>

        <!-- page end-->
        </section>