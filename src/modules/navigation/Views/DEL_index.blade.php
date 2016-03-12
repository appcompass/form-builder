@extends('layouts/basic_admin_panel')

{{-- TABS ON PANEL HEADER --}}
@section('header')
  <header class="panel-heading tab-bg-dark-navy-blue ">
    <ul class="nav nav-tabs">
    @foreach ($navmenus as $navmenu)
      <li @if ($navmenu->id === $navmenus[0]->id) class="active" @endif>
        <a data-toggle="tab" class="no-link" href="#{{ $navmenu->name }}">{{ str_replace('_', ' ', $navmenu->name) }}</a>
      </li>
    @endforeach
    </ul>
  </header>
@stop

{{-- NAVMENUS --}}
@section('body')
  <div class="tab-content">
    @foreach($navmenus as $navmenu)
    <div id="{{ $navmenu->name }}" class="tab-pane col-lg-8 col-lg-offset-2 col-md-12 @if ($navmenu->id === $navmenus[0]->id) active @endif">
      <ol>
        <li class="header">
          <div>
            {{ ucfirst(str_replace('_', ' ', $navmenu->name)) }}
            <div class="tools pull-right">
              <a
                href="#modal-edit"
                class="btn btn-xs add-subnav"
                title="Add subnav"
                data-action="modal-edit"
                data-toggle="modal"
                data-navmenu="{{ $navmenu->name }}"
                <?php /* data-inject-area="#modal-body" */ ?>
                data-click="/websites/{{ $website->id }}/navigation/create?parent={{ $navmenu->name }}"
              >
                <i class="fa fa-plus"> </i>
              </a>
            </div>
          </div>
          <ol class="sortable" data-navmenu="{{ $navmenu->name }}" href="/websites/{{ $website->id }}/navigation">
          @foreach($navmenu->items as $item)
            @include('navigation::navmenu_section', ['item' => $item, 'navmenu' => $navmenu, 'website' => $website])
          @endforeach
          </ol>
        </li>
      </ol>
    </div>
    @endforeach
  </div>

  </div>
  </div>
  </div>
  </section>

{{-- ITEMS TO ADD --}}
  <section class="panel">
    <div class="panel-heading">Pages</div>
    <div class="panel-body">
      <ol class="inline-draggable">
        @foreach ($pages as $page)
        <li
          id="menuItem_{{ $page->navItem->id }}"
          data-id="menuItem_{{ $page->navItem->id }}"
          class="draggable"
        >
        <div>
          <i class="handle fa fa-arrows"> </i>
          <img src="https://placehold.it/120x120">
          <footer>{{ $page->title }}</footer>
        </div>
      </li>
      @endforeach
    </ol>
  </div>
  </div>
  </section>

{{-- UTILS --}}
  <section class="panel">
    <div class="panel-heading">Utilities</div>
    <div class="panel-body">
      <ol class="inline-draggable">
        @foreach($utilities as $util)
          <li
            id="navitem_sub_nav"
            data-id="menuItem_{{ $util->navItem->id }}"
            href="/websites/{{ $website->id }}/navigation"
            class="draggable"
          >
            <div>
              <i class="handle fa fa-arrows"> </i>
              <img src="https://placehold.it/120x120">
              <footer>
                {{ $util->navItem->label }}
              </footer>
            </div>
          </li>
        @endforeach
      </ol>
    </div>
  </section>

@stop

@section('footer.scripts')

<script src="/assets/ui/js/jquery.nestedSortable.js"></script>

<script>

    function store(url, config, next) {

        $.ajax({
            type: config.method || 'get',
            url: url,
            data: config.data || null,
            success: function(data) {
              next(data);
            },
            error: function(message) {
              openModal('error', message, true);
            }
        })
    }

    /**
    * takes care of rebuilding the navmenu with the new items
    *
    */
    function updateNav(event, ui) {
      event.preventDefault();

      var newHierarchy = $(this).sortable('toHierarchy', {startDepthCount: 0})
      var droppedItem = $(ui.item[0]);
      var navmenu = $($(this)[0]);

      var data = {
          item_id: droppedItem.attr('data-id'),
          navmenu_name: navmenu.attr('data-navmenu'),
          hierarchy: JSON.stringify(newHierarchy)
      }

      return store(navmenu.attr('href'), {method: 'post', data: data}, function(data) { $('#record-detail').html(data); } );
    }

    $(document).ready(function(){

        $('.sortable').nestedSortable({
            handle: 'i',
            items: 'li',
            toleranceElement: '> div',
            forcePlaceholderSize: true,
            tolerance: 'pointer',
            placeholder: 'placeholder',

            isAllowed: function(placeholder, placeholderParent, currentItem) {
                // var result = $(placeholderParent).attr('data-has-content');
                // if (result === undefined || result === '1' ) {
                    return true;
                // }
            },

            // update: updateNav,
        }).disableSelection();

        $('.draggable').draggable({
          connectToSortable: '.sortable',
          helper: 'clone',
          opacity: 0.2,
          handle: '.handle',
          maxLevels: 3,
        }).disableSelection();

        $('.edit-subnav').on('click', function(event) {
          event.preventDefault();

        })

        $('.add-subnav').on('click', function(event) {
          event.preventDefault();

          console.log($(this).attr('data-navmenu'));

        })

        $('.delete-icon').on('click', function(event) {
            event.preventDefault();

            store(
              $(this).attr('href'),
              {method: 'post', data: { _method: 'delete' } },
              function(data) { $('#record-detail').html(data); }
            );

            return false;
        })
    });

</script>


<style>

  ul, li { list-style: none; margin: 0; padding: 0; min-height: 25px;}
  .sortable, .draggable {min-height: 30px;}
  .sortable form { background: rgba(128, 128, 128, 0.4);}
  .sortable li { line-height: 30px; }
  li div { line-height: 30px;}
  li.header > div { background: rgba(128, 128, 128, 0.4); text-align: center; font-weight: bold;}
  li.header > ol { padding: 0; }
  .sortable li ol { position: relative; }
  .sortable li ol a.add_subnav { position: absolute; botton: 0; right: 0;}
  .sortable li img { display: none; }
  .sortable li button { float: right; }
  .handle { float: left;  /*background: #ddd;*/  display: inline-block; line-height: 30px !important; width: 26px; margin-right: 10px; text-align: center; border-radius: 3px;}
  .handle:hover { cursor: pointer; background: #eee; }

  li input[type="text"] { border: 0; background: transparent; }
  li button { background: #fff; border: 0; }

  .placeholder { border: 1px dashed #aaa; height: 25px; background: rgba(238, 238, 238, 0.1); width: 100%;}
  .helper { background: rgba(238, 238, 238, 0.8); height: 25px; }

  .inline-draggable  { height: 120px; }
  .inline-draggable li { min-height: 120px; position: relative; width: 120px !important; float: left; margin: 10px;}
  .inline-draggable li div .handle { position: absolute; right: -15px; top: -6px;}
  .inline-draggable li div footer { color: #fff; padding: 5px 0; text-align: center; line-height: 20px; 100%; width: 100%; position: absolute; bottom: 0;left: 0;right: 0; background: rgba(128, 128, 128, 0.7); }

</style>

@stop