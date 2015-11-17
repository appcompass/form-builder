@extends('layouts/basic_admin_panel')

@section('header')
<header class="panel-heading tab-bg-dark-navy-blue ">
    <ul class="nav nav-tabs">
      @foreach ($navmenus as $navmenu)
        <li class="active">
            <a data-toggle="tab" href="#{{ $navmenu->label }}" aria-expanded="true">{{ str_replace('_', ' ', $navmenu->name) }}</a>
        </li>
      @endforeach

      <li class="pull-right"><a class="btn" href="">+ Add Navmenu</a></li>
    </ul>
</header>
@stop

@section('body')

  <div class="tab-content">
    @foreach($navmenus as $navmenu)
        <div id="{{ $navmenu->label }}" class="tab-pane active">

          <ol class="sortable" data-navmenu="{{ $navmenu->name }}">
            @foreach($navmenu->items as $item)
              <li id="menuItem_{{ $item->id }}"><i class="handle fa fa-arrows"> </i><div>{{ $item->label }}</div></li>
            @endforeach
          </ol>

        </div>
    @endforeach
  </div>

{{--  TODO this is closing the panel we opened in the base template, you can do better --}}
      </div>
    </div>
  </div>
</section>
{{--  end of horror --}}

<section class="panel">
  <div class="panel-heading">Pages</div>

  <div class="panel-body">

      <ol class="inline-draggable">
        @foreach ($pages as $page)
          <li class="draggable" data-id="menuItem_{{ $page->navItem->id }}"> <i class="handle fa fa-arrows"> </i> <img src="https://placehold.it/120x120"> <div>{{ $page->title }}</div> </li>
        @endforeach
      </ol>

    </div>

  </div>

</section>

<section class="panel">
  <div class="panel-heading">Additional Items</div>

  <div class="panel-body">

      <ol class="inline-draggable">
        <li class="draggable" id="navitem_22" data-has-content="true"> <i class="handle fa fa-arrows"> </i> <img src="https://placehold.it/120x120"> <div>Empty Container</div> </li>
      </ol>

    </div>
</section>

@stop

@section('footer.scripts')

  <script src="/assets/ui/js/jquery.nestedSortable.js"></script>

  <script>

      $(document).ready(function(){

        $('.sortable').nestedSortable({
          handle: 'i',
          items: 'li',
          toleranceElement: '> div',
          forcePlaceholderSize: true,
          tolerance: 'pointer',
          placeholder: 'placeholder',

          change: function(event, ui) {

          },

          receive: function(event, ui) {
            var newHierarchy = $(ui.item[0]).attr('data-id');
            var droppedItem = $(ui.item[0]);

            var data = {
              item_id: droppedItem.attr('data-id'),
              navmenu_name: droppedItem.parents().find('[data-navmenu]').attr('[data-navmenu]'),
              hierarchy: newHierarchy
            }

            $.ajax({
              type: 'post',
              url: droppedItem.attr('href'),
              data: data,
              success: function(data) {
                console.log(data);
              }
            })

          },

          update: function(event, ui) {

            var sortData = $('.sortable').sortable('toHierarchy', {startDepthCount: 0});
            console.log($(ui.item).attr('data-id'));
            console.log(sortData)
          }

        }).disableSelection();

        $('.draggable').draggable({
          connectToSortable: '.sortable',
          helper: 'clone',
          handle: '.handle',
          maxLevels: 3,
          stop: function(event, ui) {
            // $(this).attr('id', 'foooo');
            // console.log($(this).attr("data-id"));

            // console.log($(this).parents().find('[data-navmenu]').attr('data-navmenu'))
          }
        }).disableSelection();

    });

  </script>


  <style>

    .sortable { min-height: initial; margin-bottom: 5rem;}
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

    .placeholder { border: 1px dashed #aaa; height: 30px; width: 100%; background: rgba(175, 238, 238, 0.1); }
    .helper { background: #ddd; width: 100%;}

    .inline-draggable  {}
    .inline-draggable li { min-height: 120px; position: relative; width: 120px !important; float: left; margin-right: 10px;}
    .inline-draggable li .handle { position: absolute; right: -5px; top: -5px; height: 20px; width: 20px; line-height: 20px; font-size: 8px; border-radius: 5px;}
    .inline-draggable li .handle:hover { background: #eee; cursor: pointer;}
    .inline-draggable li div { color: #fff; font-weight: bold; display: inline-height; text-align: center; line-height: 20px; 100%; width: 100%; position: absolute; bottom: 0;left: 0;right: 0; background: rgba(128, 128, 128, 0.2); }

  </style>

@stop