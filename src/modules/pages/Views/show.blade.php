<div class="col-lg-4">
    @include('ui::partials/cms_subnav_panel', ['meta' => $meta, 'nav' => $nav])
    <section class="panel">
        <div class="panel-heading">
            Current {{ $page->title }} Template
        </div>
        <div class="panel-body">
        @foreach($sections['page'] as $layout_part => $page_section)
        <div class="col-lg-{{ 12 / intVal(count($sections['page'])) }}">
            <h3>{{ ucwords(str_replace('_', ' ', $layout_part)) }}</h3>
            <ol class="sortable" href="/websites/{{ $website->id }}/navigation" data-layout-part="{{ $layout_part }}">
            @foreach($page_section->navitems as $item)
                <li
                    id="reorder_{{ $item->id }}"
                    data-section-id="{{ $item->id }}"
                    class="item"
                >
                    <div class="btn-group btn-group-justified">
                        <span class="btn btn-default btn-xs">
                            <i class="handle fa fa-arrows"> </i>
                        </span>
                        <a
                            data-action="link"
                            href="#{{ $meta->base_url.$item->url }}"
                            data-click="{{ $meta->base_url.$item->url }}"
                            data-target="#content-edit"
                            class="btn btn-primary btn-xs"
                        >
                            {{ $item->label }}
                        </a>
                        <a
                            data-action="modal-delete"
                            href="#modal-edit"
                            data-toggle="modal"
                            data-delete="{{ $meta->base_url.'/section/'.$item->id }}"
                            data-click="/delete-modal"
                            data-inject-area="#modal-body"
                            class="btn btn-danger btn-xs"
                        >
                            Delete
                        </a>
                    </div>
                </li>
            @endforeach
            </ol>
        </div>
        @endforeach
        </div>
    </section>

    @foreach($sections['available'] as $layout_part => $page_section)
        <section class="panel">
            <div class="panel-heading">{{ $page_section->label }}</div>
            <div class="panel-body">
                <ol class="inline-draggable">
                @foreach($page_section->navitems as $item)
                    <li
                        id="menuItem_{{ $item->name }}"
                        data-section-id="{{ $item->props['id'] }}"
                        class="draggable item"
                    >
                        <i class="handle fa fa-arrows"> </i>
                        <img src="https://placehold.it/120x120">
                        <div>{{ $item->label }}</div>
                    </li>
                @endforeach
                </ol>
            </div>
        </section>
    @endforeach
</div>

<div class="col-lg-8" id="content-edit"></div>

<script>

$(document).ready(function() {

    // var config = {
    //     deleteClass: '.delete-icon'
    // }

    sortableConfig = {
        resource: '{{ $meta->base_url }}/section',
        target: '{{ $meta->data_target }}',
        to_sort_elm: 'data-section-id',
        to_sort_target: 'data-layout-part'
    };

    draggableSortableInit(sortableConfig);
})

</script>

<style>

  .sortable { min-height: 50px; margin-bottom: 5rem;}
  .sortable i, .draggable i { display: inline-block; max-width: 10px;}
  .sortable div, .draggable div { display: inline-block; }

  .sortable, .draggable { max-width: 100%; }
  .sortable li img { display: none;}
  ol, ul {list-style: none; padding: 0;}
  ol li { display: block; line-height: 20px; border: 1px solid #ddd; margin-bottom: 1rem; border-radius: 4px;}

  ol.sortable li.ui-draggable { max-width: 100%; }
  li .handle { display: inline-block; line-height: 32px; width: 30px; text-align: center; }
  li .handle:hover {cursor: pointer; }

  .placeholder { border: 1px dashed #aaa; height: 30px; width: 100%; background: rgba(175, 238, 238, 0.1); }
  .helper { background: #ddd; width: 100%;}

  .inline-draggable  {}
  .inline-draggable li { min-height: 120px; position: relative; width: 120px !important; float: left; margin-right: 10px;}
  .inline-draggable li .handle { position: absolute; right: -5px; top: -5px; height: 20px; width: 20px; line-height: 20px; font-size: 8px; border-radius: 5px;}
  .inline-draggable li .handle:hover { background: #eee; cursor: pointer;}
  .inline-draggable li div { color: #fff; font-weight: bold; display: inline-height; text-align: center; line-height: 20px; 100%; width: 100%; position: absolute; bottom: 0;left: 0;right: 0; background: rgba(128, 128, 128, 0.2); }
  .delete-icon {display: none; font-size: 9px; float: right; line-height: 34px; color: red; margin-right: 10px;}
  .delete-icon:hover {}

</style>