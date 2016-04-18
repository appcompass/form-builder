@extends('ui::modals.generic')

@section('title', "Video Photo Details")

@section('body')
    <style>
    .modal-dialog {
        width: {{ $photo->width or '1024' }}px;
        max-width: 95vw;
    }
    </style>
    <div class="modal-body row">

        <div class="img-modal">
            <img src="{{ $photo->path }}" alt="">
            <p class="mtop10"><strong>File Name:</strong> {{ $photo->name }}</p>
            <p><strong>Photo Type:</strong> {{ $photo->type or 'N/A' }}</p>
            <p><strong>Dimentions:</strong> {{ $photo->dimensions or 'N/A' }}</p>
            <p><strong>Uploaded By:</strong> {{ $photo->user->full_name or 'N/A' }}</p>
            <p><strong>Uploaded On:</strong> {{ $photo->created_at or 'N/A' }}</p>
        </div>
    </div>
    <div class="modal-footer">
        {!! Form::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) !!}
    </div>
@endsection
