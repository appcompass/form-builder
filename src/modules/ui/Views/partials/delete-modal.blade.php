@extends('ui::modals.generic')

@section('title', "Confirm Delete")

@section('body')
    {!! Form::open([
        'url' => $url,
        'method' => 'DELETE',
        'data-target' => '#main-content-out',
        'class' => 'form-horizontal bucket-form ajax-form modal-form'])
    !!}
        <div class="modal-body">
            Are you sure you wish to delete this?
        </div>
        <div class="modal-footer">
            {!! Form::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
        </div>

    {!! Form::close() !!}
@endsection