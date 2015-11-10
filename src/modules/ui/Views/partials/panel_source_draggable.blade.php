<section class="panel">
    <div class="panel-body">
        <h5>{{ $navmenu->label }}</h5>
        <ul class="nav nav-stacked sortable">
            @foreach($navmenu->items as $item)
                <li id="reorder_{{ $item->id }}" class="item" data-id="{{ $item->id }}" style="display: inline">
                    <a data-click="{{ $meta->base_url.'/'.$record->id.'/'.$item->url }}" data-target="#record-detail">
                        <i class="handle fa fa-arrows-alt"> </i> {{ ucwords($item->label) }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</section>