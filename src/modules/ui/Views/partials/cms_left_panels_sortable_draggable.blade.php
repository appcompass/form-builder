<section class="panel">
    <div class="panel-body">

        <h5>Current Template</h5>

        <ul class="nav nav-stacked sortable">

            @foreach($navmenu['target']->items as $item)

                <li id="reorder_{{ $item->id }}" class="item" data-id="{{ $item->label }}">
                    <a data-click="{{ $meta->base_url.'/'.$record->id.'/'.$item->url }}" data-id="{{ $item->label }}" data-target="#record-detail">
                        <i class="handle fa fa-arrows-alt"> </i> {{ ucwords($item->label) }}
                    </a>
                </li>
            @endforeach

            <hr>


        </ul>

        <h5>Sections available</h5>

        <ul class="nav nav-stacked sortable">

            @foreach($navmenu['source']->items as $item)
                <li id="reorder_{{ $item->id }}" class="item draggable" data-id="{{ $item->label }}">
                    <a href="#">
                        <i class="handle fa fa-arrows-alt"> </i> {{ ucwords($item->label) }}
                    </a>
                </li>
            @endforeach

        </ul>

    </div>
</section>