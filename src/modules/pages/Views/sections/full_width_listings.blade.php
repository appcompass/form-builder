@extends('ui::layouts.basic_admin_panel')

@section('header')
    {{ $section->name }}
@stop

@section('body')

  <div class="col-lg-7">

    {!! Form::model(json_decode($section->pivot->content), [
      'method' => 'put',
      'url' => '/cp/pages/'.$page->id.'/section/'.$section->id,
      'class' => 'form-horizontal bucket-form ajax-form'])
    !!}

      {!! Form::label('title', 'Header') !!}
      {!! Form::text('header', null, ['class' => 'form-control']) !!}

      {!! Form::label('sub_title', 'Sub Header') !!}
      {!! Form::text('sub_title', null, ['class' => 'form-control']) !!}

      {!! Form::label('content', 'Content') !!}
      {!! Form::textarea('content', null, ['class' => 'form-control']) !!}

      {!! Form::label('bgimage', 'Background Image') !!}
      {!! Form::file('bgimage', null, ['class' => 'form-control']) !!}

      @include('pages::sections/gallery')

      {!! Form::submit('Save', ['class' => 'btn btn-info']) !!}


    {!! Form::close() !!}

  </div>

  <div class="col-lg-5 preview">

    <h2>Preview</h2>

  </div>

@stop