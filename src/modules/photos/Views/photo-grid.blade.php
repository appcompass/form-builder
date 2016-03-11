@foreach ($photos as $photo)

    <div
        id="reorder_{{ $photo->item_id }}"
        class="item isotope-item {{ str_slug($photo->type, '_') }} {{ $photo->status }}"
        data-id="{{ $photo->id }}"
        data-path="{{ $photo->path }}"
    >
        {{-- <a href="#photoModal" data-toggle="modal" data-click="/photos/{{ $photo->id }}" data-target="#photoModalContent"> --}}
        <a href="#photoModal" data-click="/photos/{{ $photo->id }}" data-target="#photoModal" data-toggle="modal" class="item-image no-link">
            <img src="{{ $photo->path }}" alt="">
        </a>
        <ul class="item-meta nav nav-pills nav-stacked">
            <li><strong>Status:</strong> <span class="pull-right">{{ $photo->status or 'N/A' }}</span></li>
            <li><strong>Photo Type:</strong> <span class="pull-right">{{ $photo->type or 'N/A' }}</span></li>
            <li><strong>Uploaded By:</strong> <span class="pull-right">{{ $photo->user->full_name or 'N/A' }}</span></li>
            <li><strong>Uploaded On:</strong> <span class="pull-right">{{ $photo->created_at or 'N/A' }}</span></li>
        </ul>
        @if (!isset($is_modal) OR !$is_modal)
        <div class="item-actions text-right">
            <input type="checkbox" name="bulk_edit" value="{{ $photo->id }}">
            {{--
            <a
                href="#modal-edit"
                class="btn btn-info  btn-sm"
                title="Add subnav"
                data-action="modal-edit"
                data-toggle="modal"
                data-inject-area="#modal-body"
                data-click="/photos/{{ $photo->id }}"
            >
                <i class="fa fa-pencil"></i>
                Edit
            </a>
            --}}
            <a
                data-action="modal-delete"
                href="#modal-edit"
                data-toggle="modal"
                data-delete="/photos/{{ $photo->id }}"
                data-click="/delete-modal"
                data-inject-area="#modal-body"
                class="btn btn-danger"
            >
                <i class="fa fa-times"></i>
                Delete
            </a>
        </div>
        @endif
    </div>

@endforeach
<script>
        $('.item-actions input[type=checkbox]').iCheck({
            checkboxClass: 'icheckbox_square',
            radioClass: 'iradio_square',
            // increaseArea: '20%' // optional
        });
</script>
