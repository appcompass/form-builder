@foreach ($videos as $video)

    <div
        id="reorder_{{ $video->item_id }}"
        class="item isotope-item {{ str_slug($video->type, '_') }} {{ $video->status }}"
        data-id="{{ $video->id }}"
        data-path="{{ $video->path }}"
    >
        {{-- <a href="#videoModal" data-toggle="modal" data-click="/videos/{{ $video->id }}" data-target="#videoModalContent"> --}}
        <div class="wistia_embed wistia_async_{{$video->meta->hashed_id}}">&nbsp;</div> {{--  videoFoam=true --}}
        <ul class="item-meta nav nav-pills nav-stacked">
            <li><strong>Name:</strong> <span class="pull-right">{{ $video->name or 'N/A' }}</span></li>
            <li><strong>Duration:</strong> <span class="pull-right">{{ $photo->meta->duration or 'N/A' }}</span></li>
            <li><strong>Uploaded By:</strong> <span class="pull-right">{{ $video->user->full_name or 'N/A' }}</span></li>
            <li><strong>Uploaded On:</strong> <span class="pull-right">{{ $video->created_at or 'N/A' }}</span></li>
        </ul>
        @if (!isset($is_modal) OR !$is_modal)
        @can('destroy', new Photo)
        <div class="item-actions text-right">
            <input type="checkbox" name="bulk_edit" value="{{ $video->id }}">
            {{--
            <a
                href="#modal-edit"
                class="btn btn-info  btn-sm"
                title="Add subnav"
                data-action="modal-edit"
                data-toggle="modal"
                data-inject-area="#modal-body"
                data-click="/videos/{{ $video->id }}"
            >
                <i class="fa fa-pencil"></i>
                Edit
            </a>
            --}}
            <a
                data-action="modal-delete"
                href="#modal-edit"
                data-toggle="modal"
                @if(!empty($meta->base_url))
                data-delete="{{$meta->base_url}}/{{ $video->id }}"
                @else
                data-delete="/videos/{{ $video->id }}"
                @endif
                data-click="/delete-modal"
                data-inject-area="#modal-body"
                class="btn btn-danger"
            >
                <i class="fa fa-times"></i>
                Delete
            </a>
        </div>
        @endcan
        @endif
    </div>

@endforeach
<script charset="ISO-8859-1" src="//fast.wistia.com/assets/external/E-v1.js" async></script>
