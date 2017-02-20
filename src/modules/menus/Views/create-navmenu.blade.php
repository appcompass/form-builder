@extends('ui::modals.generic')

@section('title', "Add Subnav")

@section('body')
  {!! Form::open([
      'url' => '/websites/'.$website->id.'/navigation/'.$parent->name,
      'method' => 'PUT',
      'data-target' => 'record-detail',
      'class' => 'form-horizontal bucket-form ajax-form'])
  !!}
  <div class="modal-body">

      {!! Form::hidden('parent', $parent->name) !!}

      <div class="form-group">
        {!! Form::label('label', 'Label', ['class' => 'col-lg-3 control-label']) !!}
        <div class="col-lg-6">
          {!! Form::text('label', null, ['class' => 'form-control', 'placeholder' => 'Container\'s label']) !!}
        </div>
      </div>

      <div class="form-group">
        {!! Form::label('url', 'url', ['class' => 'col-lg-3 control-label']) !!}
        <div class="col-lg-6">
          {!! Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'https://']) !!}
        </div>
      </div>

  </div>
  <div class="modal-footer">
    {!! Form::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
    {!! Form::submit('Add container', ['class' => 'btn btn-success']) !!}
  </div>

  {!! Form::close() !!}
@endsection