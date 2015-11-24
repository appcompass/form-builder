@extends('layouts/basic_admin_panel')
{{-- @extends('ui::layouts/cms_internal_layout') --}}

@section('header')
    page editor
@stop

@section('body')
    <section class="panel">
        <div class="panel-body">
        @foreach($sections['page'] as $page_section)
            <ol class="sortable" href="/websites/{{ $website->id }}/navigation">
            @foreach($page_section->items as $item)
                <li
                    id="menuItem_{{ $item->id }}"
                    data-id="menuItem_{{ $item->id }}"
                    class="draggable"
                >
                    <i class="handle fa fa-arrows"> </i>
                    <img src="https://placehold.it/120x120">
                    <div>{{ $item->label }}</div>
                </li>
            @endforeach
            </ol>
        @endforeach
        </div>
    </section>

{{-- Close panel opened in the master template --}}
</div>
</div>
</div>
</section>

@foreach($sections['available'] as $page_section)
    <section class="panel">
        <div class="panel-heading">{{ $page_section->label }}</div>
        <div class="panel-body">
            <ol class="inline-draggable">
            @foreach($page_section->items as $item)
                <li
                    id="menuItem_{{ $item->name }}"
                    data-id="menuItem_{{ $item->name }}"
                    class="draggable"
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
@stop

@section('footer.scripts')

<script>

    function store(url, config, next) {

        $.ajax({
            type: config.method || 'get',
            url: url,
            data: config.data || null,
            success: function(data) {
              next(data);
            },
            error: function(data) {}
        })
    }


    $(document).ready(function(){

        $('.just-ajax-save').on('submit', function(e) {
            e.preventDefault();

            var data = {
                label: $(this).find('[name="label"]').val()
            }

            store($(this).attr('action'), {method: 'put', data: data}, function(data) { console.log(data) });

        })

        $('.sortable').nestedSortable({
            handle: 'i',
            items: 'li',
            toleranceElement: '> div',
            forcePlaceholderSize: true,
            tolerance: 'pointer',
            placeholder: 'placeholder',
            isTree: true,

            isAllowed: function(placeholder, placeholderParent, currentItem) {
                var result = $(placeholderParent).attr('data-has-content');
                if (result === undefined || result === '1' ) { // stupid php don't have time for this
                    return true;
                }
            },

            receive: function(event, ui) {

                var newHierarchy = $(this).sortable('toHierarchy', {startDepthCount: 0})
                var droppedItem = $(ui.item[0]);
                var navmenu = droppedItem.parents().find('[data-navmenu]');

                var data = {
                    item_id: droppedItem.attr('data-id'),
                    navmenu_name: navmenu.attr('data-navmenu'),
                    hierarchy: JSON.stringify(newHierarchy)
                }

                store(navmenu.attr('href'), {method: 'post', data: data}, function(data) { $('#record-detail').html(data); } );
            },

            update: function(event, ui) {
                // var sortData = $('.sortable').sortable('toHierarchy', {startDepthCount: 0});
                var sortData = $(this).sortable('toHierarchy', {startDepthCount: 0});
                // console.log(sortData);
            }
        }).disableSelection();

        $('.draggable').draggable({
          connectToSortable: '.sortable',
          helper: 'clone',
          handle: '.handle',
          maxLevels: 3,
        }).disableSelection();
    });

</script>

<style>

  .sortable { min-height: 50px; margin-bottom: 5rem;}
  .sortable i, .draggable i { display: inline-block; }
  .sortable div, .draggable div { display: inline-block; }

  .sortable, .draggable { max-width: 50%; }
  .sortable li img { display: none;}
  ol, ul {list-style: none;}
  ol li { display: block; line-height: 20px; border: 1px solid #ddd; margin-bottom: 2px; border-radius: 4px;}
  li > ol { margin-top: 0px; }
  li div { padding: 5px 10px; }
  ol.sortable li.ui-draggable { max-width: 100%; }
  li .handle { background: #ddd; display: inline-block; line-height: 32px; width: 30px; text-align: center; }
  li .handle:hover {cursor: pointer; background: #eee;}

  .placeholder { border: 1px dashed #aaa; height: 30px; width: 100%; background: rgba(175, 238, 238, 0.1); }
  .helper { background: #ddd; width: 100%;}

  .inline-draggable  {}
  .inline-draggable li { min-height: 120px; position: relative; width: 120px !important; float: left; margin-right: 10px;}
  .inline-draggable li .handle { position: absolute; right: -5px; top: -5px; height: 20px; width: 20px; line-height: 20px; font-size: 8px; border-radius: 5px;}
  .inline-draggable li .handle:hover { background: #eee; cursor: pointer;}
  .inline-draggable li div { color: #fff; font-weight: bold; display: inline-height; text-align: center; line-height: 20px; 100%; width: 100%; position: absolute; bottom: 0;left: 0;right: 0; background: rgba(128, 128, 128, 0.2); }

</style>

@stop