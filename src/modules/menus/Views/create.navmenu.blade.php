@extends('ui::modals.generic')

@yield('title', "Add Subnav")

@yield('body')
  {!! Form::open([
      'url' => '/websites/'.$website->id.'/navigation/'.$navmenu->name,
      'method' => 'POST',
      'data-target' => '',
      'class' => 'form-horizontal bucket-form ajax-form'])
  !!}
  <div class="modal-body">

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