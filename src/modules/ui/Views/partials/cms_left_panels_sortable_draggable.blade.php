<section class="panel">
    <div class="panel-body">

        <h5>Current Template</h5>

        <ul class="nav nav-stacked sortable">

            @foreach($navmenu['target']->items as $item)

                <li id="reorder_{{ $item->id }}" class="item" data-id="{{ $item->label }}">
                    <a href="#{{ $meta->base_url.'/'.$item->url }}" data-click="{{ $meta->base_url.'/'.$item->url }}"
                       data-id="{{ $item->label }}"
                       data-target="#record-detail"
                       style="display: inline-block"
                    >
                        <i class="handle fa fa-arrows-alt"> </i> {{ ucwords($item->label) }}
                    </a>
                    <a data-id="{{$item->id}}" href="{{ $meta->base_url.'/section/'.$item->id }}" class="delete-icon" style="display: none; float: right">
                        <i class="fa fa-trash-o"> </i> Delete
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